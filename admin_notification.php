<?php
require_once __DIR__ . '/includes/admin_check.php';
require_once __DIR__ . '/config/database.php';

// Ambil daftar pengguna terdaftar untuk opsi kirim pesan
$stmt = $pdo->query("SELECT id, email, display_name FROM users ORDER BY display_name ASC");
$users = $stmt->fetchAll();

require_once __DIR__ . '/views/admin_notification_view.php';