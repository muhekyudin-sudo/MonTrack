<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
}
header('Location: ../../dashboard.php?status=trx_deleted');
exit;