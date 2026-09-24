<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';
    $display_name = trim($_POST['display_name'] ?? '');

    if (empty($email) || empty($password) || empty($display_name)) {
        header('Location: ../../register.php?status=failed');
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        header('Location: ../../register.php?status=failed');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (email, password, display_name) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$email, $hashedPassword, $display_name])) {
        header('Location: ../../login.php?status=registered');
    } else {
        header('Location: ../../register.php?status=failed');
    }
    exit;
}