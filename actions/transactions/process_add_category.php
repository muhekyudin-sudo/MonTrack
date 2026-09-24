<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $name = trim($_POST['category_name'] ?? '');
    $type = $_POST['category_type'] ?? 'expense';

    if (!empty($name) && in_array($type, ['income', 'expense'])) {
        $stmt = $pdo->prepare("INSERT INTO categories (user_id, name, type, is_default) VALUES (?, ?, ?, 0)");
        $stmt->execute([$_SESSION['user_id'], $name, $type]);
    }
    header('Location: ../../add_transaction.php?status=cat_added');
    exit;
}