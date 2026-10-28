<?php
require_once __DIR__ . '/session_init.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: dashboard.php?status=failed');
    exit;
}