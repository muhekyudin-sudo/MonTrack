<?php
require_once __DIR__ . '/includes/session_init.php';
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
require_once __DIR__ . '/views/auth/register_view.php';