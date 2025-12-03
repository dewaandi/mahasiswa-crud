-- schema.sql
CREATE DATABASE IF NOT EXISTS tugas_mahasiswa;
USE tugas_mahasiswa;

CREATE TABLE IF NOT EXISTS mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  nim VARCHAR(20) NOT NULL UNIQUE,
  prodi ENUM('TI','SI','MI') NOT NULL,
  angkatan INT NOT NULL,
  status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  foto VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
