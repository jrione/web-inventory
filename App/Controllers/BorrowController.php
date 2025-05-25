<?php

namespace App\Controllers;
use App\Core\Helper as H;
use App\Core\Database as DB;

class BorrowController{
    public static $validPayload = [];
    
    public static function getAllDataBorrow(){
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
        
        $q="
        SELECT 
                u.full_name AS nama_peminjam,
                u.email AS email_peminjam,
                u.no_hp AS telepon_peminjam,
                u.username AS username_peminjam,
                u.roles AS role_peminjam,
                
                inv.kode_barang,
                inv.nama_barang,
                inv.satuan_barang,
                inv.harga_beli,
                CASE 
                    WHEN inv.status_barang = 1 THEN 'Aktif' 
                    ELSE 'Tidak Aktif' 
                END AS status_barang,
                
                COUNT(ib.id_item_borrowed) AS total_transaksi,
                SUM(ib.total_item_borrowed) AS total_qty_dipinjam,
                MIN(ib.created_at) AS pinjaman_pertama,
                MAX(ib.created_at) AS pinjaman_terakhir,
                SUM(ib.total_item_borrowed * inv.harga_beli) AS total_nilai_pinjaman,
                
                inv.jumlah_barang AS stok_tersedia_saat_ini,
                ROUND((SUM(ib.total_item_borrowed) / inv.jumlah_barang) * 100, 2) AS persentase_dari_stok
                
            FROM tb_item_borrowed ib
            INNER JOIN tb_inventory inv ON ib.id_barang = inv.id_barang
            INNER JOIN tb_user u ON ib.user_id = u.user_id
            GROUP BY 
                u.user_id, u.full_name, u.email, u.no_hp, u.username, u.roles,
                inv.id_barang, inv.kode_barang, inv.nama_barang, inv.satuan_barang, 
                inv.harga_beli, inv.status_barang, inv.jumlah_barang
            ORDER BY u.full_name ASC, total_qty_dipinjam DESC;
        ";
        $res = DB::queryRaw($q);
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["error" => "Unexpected Error"],500);
        }
    }
    public static function getDataBorrowByUser(){
        $roles = H::BasicAuth();
        self::$validPayload = ["user_id"];
        $payload=H::receiveDataJSON(self::$validPayload);
        
        $q="
        SELECT 
                u.full_name AS nama_peminjam,
                u.email AS email_peminjam,
                u.no_hp AS telepon_peminjam,
                u.username AS username_peminjam,
                u.roles AS role_peminjam,
                
                inv.id_barang,
                inv.kode_barang,
                inv.nama_barang,
                inv.satuan_barang,
                inv.harga_beli,
                CASE 
                    WHEN inv.status_barang = 1 THEN 'Aktif' 
                    ELSE 'Tidak Aktif' 
                END AS status_barang,
                
                COUNT(ib.id_item_borrowed) AS total_transaksi,
                SUM(ib.total_item_borrowed) AS total_qty_dipinjam,
                MIN(ib.created_at) AS pinjaman_pertama,
                MAX(ib.created_at) AS pinjaman_terakhir,
                SUM(ib.total_item_borrowed * inv.harga_beli) AS total_nilai_pinjaman,
                
                inv.jumlah_barang AS stok_tersedia_saat_ini,
                ROUND((SUM(ib.total_item_borrowed) / inv.jumlah_barang) * 100, 2) AS persentase_dari_stok
                
            FROM tb_item_borrowed ib
            INNER JOIN tb_inventory inv ON ib.id_barang = inv.id_barang
            INNER JOIN tb_user u ON ib.user_id = u.user_id
            WHERE ib.user_id=?
            GROUP BY 
                u.user_id, u.full_name, u.email, u.no_hp, u.username, u.roles,
                inv.id_barang, inv.kode_barang, inv.nama_barang, inv.satuan_barang, 
                inv.harga_beli, inv.status_barang, inv.jumlah_barang
            ORDER BY u.full_name ASC, total_qty_dipinjam DESC;
        ";
        $res = DB::queryRaw($q,array_values($payload));
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["error" => "Unexpected Error"],500);
        }

    }
    public static function addBorrow(){
        $roles = H::BasicAuth();
        self::$validPayload = ["total_item_borrowed", "id_barang","user_id"];
        $payload=H::receiveDataJSON(self::$validPayload);

        $qCheckAvail="SELECT jumlah_barang FROM tb_inventory WHERE id_barang=? ";
        $res = DB::queryRaw($qCheckAvail,[$payload['id_barang']]);
        if ($res){
            $jml = $res->fetchAll(\PDO::FETCH_ASSOC);
            if($payload['total_item_borrowed'] > $jml[0]['jumlah_barang']){
                return H::returnDataJSON(["message" => "Jumlah melebihi barang yang tersedia"],400);
                exit();
            }
            
            $dataBorrow=[];
            foreach($payload as $d){
                array_push($dataBorrow,$d);
            }
            $q="INSERT INTO tb_item_borrowed(total_item_borrowed,id_barang,user_id) VALUE (?,?,?)";
            try{
                DB::queryRaw($q,$dataBorrow);
            } catch(\PDOException $e){
                return H::returnDataJSON(["message" => $e->getMessage()],500);
            }
            
            $updatedJumlahBarang=$jml[0]['jumlah_barang'] - $payload['total_item_borrowed'];
            $params= [
                "where" => [
                    "id_barang" => $payload["id_barang"]
                ],
                "dataUpdated" => [
                    "jumlah_barang" => $updatedJumlahBarang
                ]
            ];
            ob_start();
            ApiController::updateDataBarang(true,$params);
            ob_end_clean();

            return H::returnDataJSON(["message" => "Berhasil meminjam"]);
        }
        else{
            return H::returnDataJSON(["message" => "Unexpected Error"],500);
        }
        
    }
    public static function returnBorrow(){
        $roles = H::BasicAuth();
        self::$validPayload = ["id_barang","user_id","total_item_borrowed"];
        $payload=H::receiveDataJSON(self::$validPayload);

        
        $q="DELETE FROM tb_item_borrowed WHERE user_id='".$payload['user_id']."' AND id_barang='".$payload['id_barang']."'";
        try{
            DB::queryRaw($q);
        } catch(\PDOException $e){
            $returnData = H::returnDataJSON(["unexpected_error" => $e->getMessage()],500);
            return $returnData;
            exit();
        }

        $qCheckAvail="SELECT jumlah_barang FROM tb_inventory WHERE id_barang=? ";
        $res = DB::queryRaw($qCheckAvail,[$payload['id_barang']]);
        if ($res){
            $jml = $res->fetchAll(\PDO::FETCH_ASSOC);
            $updatedJumlahBarang=$jml[0]['jumlah_barang'] + $payload['total_item_borrowed'];

            $params= [
                "where" => [
                    "id_barang" => $payload["id_barang"]
                ],
                "dataUpdated" => [
                    "jumlah_barang" => $updatedJumlahBarang
                ]
            ];
            ob_start();
            ApiController::updateDataBarang(true,$params);
            ob_end_clean();
            return H::returnDataJSON(["message" => "Data Berhasil dihapus!"]);
        }
        else{
            return H::returnDataJSON(["message" => "Unexpected Error"],500);
        }

    }
}