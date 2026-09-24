<?php
// config/database.php

$host     = 'localhost';
$db_name  = 'money_tracker';
$username = 'root';
$password = ''; // lihat lewat ikon mata di halaman MySQL Databases

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal. Silakan coba lagi nanti atau hubungi admin.");
}