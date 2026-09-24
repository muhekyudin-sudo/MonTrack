<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $transaction_id   = $_POST['transaction_id'] ?? null;
    $user_id          = $_SESSION['user_id'];
    $category_id      = $_POST['category_id'] ?? null;
    $amount           = $_POST['amount'] ?? 0;
    $transaction_type = $_POST['transaction_type'] ?? 'expense';
    $transaction_date = $_POST['transaction_date'] ?? date('Y-m-d');
    $notes            = trim($_POST['notes'] ?? '');

    if ($transaction_id && $category_id && $amount > 0) {
        $stmt = $pdo->prepare("
            UPDATE transactions 
            SET category_id = ?, amount = ?, transaction_type = ?, transaction_date = ?, notes = ? 
            WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$category_id, $amount, $transaction_type, $transaction_date, $notes, $transaction_id, $user_id]);
        header('Location: ../../dashboard.php?status=trx_updated');
        exit;
    }
}
header('Location: ../../dashboard.php?status=failed');
exit;