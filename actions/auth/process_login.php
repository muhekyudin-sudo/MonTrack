<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Cari user berdasarkan email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 2. Verifikasi keberadaan user dan kecocokan password hash
    if ($user && password_verify($password, $user['password'])) {
        // Login Berhasil
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['display_name'];
        $_SESSION['role']      = $user['role'] ?? 'user'; // Simpan role ke session
        
        header('Location: ../../dashboard.php');
        exit;
    } else {
        // Login Gagal
        header('Location: ../../login.php?status=failed');
        exit;
    }
} else {
    // Jika diakses bukan via POST
    header('Location: ../../login.php');
    exit;
}