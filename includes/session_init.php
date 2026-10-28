<?php
// includes/session_init.php
// Zona waktu aplikasi (WIB). Tanpa ini PHP memakai zona waktu server hosting,
// sehingga date('Y-m-d') bisa tertinggal 1 hari pada pagi hari.
date_default_timezone_set('Asia/Jakarta');
// Pengaturan session terpusat: umur 30 hari + folder penyimpanan sendiri.
if (session_status() === PHP_SESSION_NONE) {
    $lifetime = 60 * 60 * 24 * 30; // 30 hari

    // Folder session sendiri, supaya tidak dibersihkan oleh website lain di server yang sama
    $path = __DIR__ . '/../sessions';
    if (!is_dir($path)) {
        @mkdir($path, 0700, true);
    }
    if (is_dir($path) && is_writable($path)) {
        session_save_path($path);
    }

    ini_set('session.gc_maxlifetime', (string)$lifetime);

    session_set_cookie_params([
        'lifetime' => $lifetime,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}
