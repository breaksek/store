-- 1. Tabel Users (Untuk Admin dan Pembeli)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel Kategori Game (Free Fire, Mobile Legends, dll)
CREATE TABLE kategori_game (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_game VARCHAR(50) NOT NULL,
    logo_game VARCHAR(255)
);

-- 3. Tabel Produk (Daftar Diamond dan Harga)
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_game INT,
    nama_produk VARCHAR(100) NOT NULL, -- Contoh: "140 Diamonds"
    harga INT NOT NULL,
    FOREIGN KEY (id_game) REFERENCES kategori_game(id) ON DELETE CASCADE
);