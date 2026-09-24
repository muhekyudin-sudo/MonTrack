<?php
require_once __DIR__ . '/includes/admin_check.php';
require_once __DIR__ . '/config/database.php';

// 1. Hitung Total Pengguna Terdaftar
$stmtUsers = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
$total_users = $stmtUsers->fetch()['total_users'] ?? 0;

// 2. Hitung Total Transaksi Sistem
$stmtTrx = $pdo->query("SELECT COUNT(*) AS total_trx, SUM(amount) AS total_val FROM transactions");
$trx_stats = $stmtTrx->fetch();

// 3. Ambil Daftar Pengguna
$stmtUserList = $pdo->query("SELECT id, display_name, email, role, created_at FROM users ORDER BY id DESC");
$user_list = $stmtUserList->fetchAll();

require_once __DIR__ . '/views/admin_dashboard_view.php';