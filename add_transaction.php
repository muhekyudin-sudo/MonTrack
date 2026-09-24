<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/config/database.php';

$user_id = $_SESSION['user_id'] ?? 0;

try {
    // Ambil kategori default sistem (user_id IS NULL) dan kategori kustom user aktif
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE (user_id IS NULL OR user_id = ?) AND is_deleted = 0 ORDER BY name ASC");
    $stmt->execute([$user_id]);
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

// Pastikan mengarah ke sub-folder views/transactions/
require_once __DIR__ . '/views/transactions/add_transaction_view.php';