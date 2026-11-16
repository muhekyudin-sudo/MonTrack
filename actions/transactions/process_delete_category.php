<?php
require_once __DIR__ . '/../../includes/session_init.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $user_id = (int)$_SESSION['user_id'];

    if ($category_id && $user_id > 0) {
        // Soft delete: tandai is_deleted = 1 hanya untuk kategori milik user yang bersangkutan dan bukan bawaan sistem
        // Riwayat transaksi yang sudah ada di tabel `transactions` tidak tersentuh sama sekali
        $stmt = $pdo->prepare("UPDATE categories SET is_deleted = 1 WHERE id = ? AND user_id = ? AND (is_default = 0 OR is_default IS NULL)");
        $stmt->execute([$category_id, $user_id]);
    }

    header('Location: ../../add_transaction.php?status=cat_deleted');
    exit;
}

header('Location: ../../add_transaction.php');
exit;
