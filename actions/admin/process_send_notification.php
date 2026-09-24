<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $target_user_id = $_POST['user_id'] ?? null;
    $title          = trim($_POST['title'] ?? '');
    $message        = trim($_POST['message'] ?? '');

    if ($target_user_id && !empty($title) && !empty($message)) {
        
        // JIKA PILIH "SEMUA PENGGUNA" (BROADCAST)
        if ($target_user_id === 'all') {
            // 1. Ambil seluruh ID pengguna terdaftar
            $stmtUsers = $pdo->query("SELECT id FROM users");
            $allUsers  = $stmtUsers->fetchAll();

            // 2. Lakukan looping kirim ke setiap ID
            $stmtNotif = $pdo->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)");
            foreach ($allUsers as $u) {
                $stmtNotif->execute([$u['id'], $title, $message]);
            }
        } 
        // JIKA PILIH 1 PENGGUNA SPESIFIK
        else {
            $stmtNotif = $pdo->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)");
            $stmtNotif->execute([$target_user_id, $title, $message]);
        }

        header('Location: ../../admin_notification.php?status=notif_sent');
        exit;
    }
}
header('Location: ../../admin_notification.php?status=failed');
exit;