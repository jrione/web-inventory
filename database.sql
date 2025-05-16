-- DATABASE YANG DIGUNAKAN
-- MariaDB 10.3

CREATE DATABASE db_inventory;
USE db_inventory;

CREATE TABLE tb_inventory (
    `id_barang` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kode_barang` VARCHAR(20) NOT NULL,
    `nama_barang` VARCHAR(50) NOT NULL,
    `jumlah_barang` INT(10) DEFAULT 0,
    `satuan_barang` ENUM('kg','pcs','liter','meter') NOT NULL,
    `harga_beli` DOUBLE(20,2),
    `status_barang` BOOLEAN default false,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);


CREATE TABLE tb_user (
    `user_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `roles` ENUM('admin','user') NOT NULL DEFAULT 'user',
    `full_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `no_hp` VARCHAR(13) DEFAULT NULL,
    `username` VARCHAR(13) NOT NULL UNIQUE,
    `password` text DEFAULT NULL,
    `img` varchar(50) NOT NULL DEFAULT 'default_profile.svg',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

CREATE TABLE tb_item_borrowed(
    `id_item_borrowed` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `total_item_borrowed` INT(10) NOT NULL,
    `id_barang` INT(10) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    FOREIGN KEY (`id_barang`) REFERENCES tb_inventory(id_barang) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES tb_user(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);

 INSERT INTO tb_user(roles,full_name,email,username,password) VALUE('admin','Pajri Zahrawaani Ahmad','admin@admin.com','jrione','$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC');