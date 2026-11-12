<?php
// Menyimpan pilihan pengguna: reset saldo setiap awal bulan (aktif / mati)
require_once __DIR__ . '/../../includes/session_init.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    // Hanya terima '1' (aktif). Selain itu dianggap 0 (mati).
    $value = (isset($_POST['monthly_reset']) && $_POST['monthly_reset'] === '1') ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE users SET monthly_reset = ? WHERE id = ?");
    $stmt->execute([$value, $_SESSION['user_id']]);

    header('Location: ../../dashboard.php?status=' . ($value ? 'reset_on' : 'reset_off'));
    exit;
}

header('Location: ../../dashboard.php?status=failed');
exit;
