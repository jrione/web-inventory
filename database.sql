-- DATABASE YANG DIGUNAKAN
-- MariaDB 10.3

CREATE DATABASE db_inventory;
USE db_inventory;

CREATE TABLE tb_inventory (
    `id_barang` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kode_barang` VARCHAR(20) NOT NULL UNIQUE,
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



INSERT INTO tb_inventory (kode_barang, nama_barang, jumlah_barang, satuan_barang, harga_beli, status_barang)
VALUES
('BRG001', 'Kabel LAN Cat6', 50, 'meter', 2500.00, true),
('BRG002', 'Mouse Logitech M170', 20, 'pcs', 120000.00, true),
('BRG003', 'Tinta Printer Canon 810', 10, 'pcs', 95000.00, true),
('BRG004', 'Kertas A4 70gsm', 30, 'kg', 42000.00, true),
('BRG005', 'Flashdisk 32GB', 15, 'pcs', 70000.00, true),
('BRG006', 'Minyak Pelumas Mesin', 5, 'liter', 56000.00, false),
('BRG007', 'Obeng Set', 12, 'pcs', 38000.00, true),
('BRG008', 'Kabel HDMI 3M', 25, 'meter', 18000.00, true),
('BRG009', 'Lem Fox Putih', 8, 'liter', 22000.00, true),
('BRG010', 'Power Supply 450W', 6, 'pcs', 320000.00, false),
('BRG011', 'Karton Dus Besar', 40, 'pcs', 7000.00, true),
('BRG012', 'Stiker Label Barcode', 50, 'meter', 15000.00, true),
('BRG013', 'Sabun Pembersih Lantai', 10, 'liter', 18000.00, true),
('BRG014', 'Kabel Roll 10M', 7, 'pcs', 55000.00, true),
('BRG015', 'Laptop Lenovo V14', 3, 'pcs', 7200000.00, false);


INSERT INTO tb_user (roles,full_name,email,username,password) VALUE('admin','Pajri Zahrawaani Ahmad','admin@admin.com','jrione','$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC');
INSERT INTO tb_user (roles, full_name, email, no_hp, username, password)
VALUES
('admin', 'Admin Sistem', 'admin@example.com', '081234567890', 'admin1', '$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC'),
('user', 'Budi Santoso', 'budi@example.com', '081234567891', 'budi123', '$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC'),
('user', 'Siti Aminah', 'siti@example.com', '081234567892', 'sitiaminah', '$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC'),
('user', 'Dian Prasetyo', 'dian@example.com', '081234567893', 'dianp', '$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC'),
('user', 'Rina Marlina', 'rina@example.com', '081234567894', 'rinam', '$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC');