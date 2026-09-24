<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("DELETE FROM transactions WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}

header('Location: ../../dashboard.php?status=trx_all_deleted');
exit;