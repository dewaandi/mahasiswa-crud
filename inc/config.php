<?php
// inc/config.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Database credentials - sesuaikan dengan lingkungan Anda
const DB_HOST = '127.0.0.1';
const DB_NAME = 'tugas_mahasiswa';
const DB_USER = 'root';
const DB_PASS = ''; // isi password MySQL Anda

// Base URL (opsional, jika dijalankan di subfolder)
const BASE_URL = ''; // mis. '/mahasiswa-crud/' atau kosong untuk root

// Simple autoload untuk kelas
spl_autoload_register(function ($class_name) {
    $path = __DIR__ . '/../class/' . $class_name . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});
