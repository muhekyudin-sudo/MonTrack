<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/config/database.php';

$user_id = $_SESSION['user_id'];
$transaction_id = $_GET['id'] ?? null;

if (!$transaction_id) {
    header('Location: dashboard.php');
    exit;
}

// 1. Ambil data transaksi yang ingin diedit milik user aktif
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = ? AND user_id = ?");
$stmt->execute([$transaction_id, $user_id]);
$transaction = $stmt->fetch();

if (!$transaction) {
    header('Location: dashboard.php');
    exit;
}

// 2. Ambil pilihan kategori
$stmtCat = $pdo->prepare("SELECT * FROM categories WHERE (user_id IS NULL OR user_id = ?) AND is_deleted = 0 ORDER BY name ASC");
$stmtCat->execute([$user_id]);
$categories = $stmtCat->fetchAll();

require_once __DIR__ . '/views/transactions/edit_transaction_view.php';