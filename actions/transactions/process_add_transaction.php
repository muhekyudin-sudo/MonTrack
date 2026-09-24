<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id          = $_SESSION['user_id'];
    $category_id      = $_POST['category_id'] ?? null;
    $amount           = $_POST['amount'] ?? 0;
    $transaction_type = $_POST['transaction_type'] ?? 'expense';
    $transaction_date = $_POST['transaction_date'] ?? date('Y-m-d');
    $notes            = trim($_POST['notes'] ?? '');

    if ($category_id && $amount > 0) {
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, category_id, amount, transaction_type, transaction_date, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $category_id, $amount, $transaction_type, $transaction_date, $notes]);
        header('Location: ../../dashboard.php?status=trx_success');
        exit;
    }
}
header('Location: ../../add_transaction.php?status=failed');
exit;