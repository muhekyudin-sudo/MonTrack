<?php
// views/partials/mt_navbar.php
// Area user : $mt_active = 'add';  include __DIR__ . '/../partials/mt_navbar.php';
// Area admin: $mt_area = 'admin'; $mt_active = 'admin_dashboard'; include __DIR__ . '/partials/mt_navbar.php';
$mt_active   = $mt_active ?? '';
$mt_area     = $mt_area ?? 'user';
$mt_is_admin = ($_SESSION['role'] ?? '') === 'admin';

if ($mt_area === 'admin') {
    $mt_home  = 'admin_dashboard.php';
    $mt_links = [
        ['key' => 'admin_dashboard',    'href' => 'admin_dashboard.php',    'label' => 'Dashboard Admin'],
        ['key' => 'admin_notification', 'href' => 'admin_notification.php', 'label' => 'Kirim Notifikasi'],
        ['key' => 'user_view',          'href' => 'dashboard.php',          'label' => 'Ke Tampilan User', 'style' => 'color:#f59e0b;'],
    ];
} else {
    $mt_home  = 'dashboard.php';
    $mt_links = [
        ['key' => 'dashboard', 'href' => 'dashboard.php',      'label' => 'Dashboard'],
        ['key' => 'add',       'href' => 'add_transaction.php', 'label' => 'Tambah Transaksi'],
    ];
    if ($mt_is_admin) {
        $mt_links[] = ['key' => 'admin', 'href' => 'admin_dashboard.php', 'label' => 'Admin Panel', 'style' => 'color:#f59e0b;'];
    }
}
?>
<nav class="mt-navbar">
    <div class="container-xl py-3 d-flex align-items-center justify-content-between flex-wrap gap-2 gap-md-3">
        <div class="d-flex align-items-center gap-2">
            <button class="mt-icon-btn d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mtMobileMenu" aria-expanded="false" aria-controls="mtMobileMenu">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            <a href="<?= $mt_home; ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                <span class="mt-logo-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="3"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </span>
                <span class="mt-logo-text">Mon<span class="mt-accent">Track</span></span>
                <?php if ($mt_area === 'admin'): ?><span class="mt-admin-tag">Admin</span><?php endif; ?>
            </a>
            <div class="d-none d-md-flex align-items-center gap-1">
                <?php foreach ($mt_links as $l): ?>
                    <a href="<?= $l['href']; ?>" class="mt-nav-link <?= $mt_active === $l['key'] ? 'active' : ''; ?>"<?= !empty($l['style']) ? ' style="' . $l['style'] . '"' : ''; ?>><?= $l['label']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 gap-sm-3">
            <div class="d-flex align-items-center gap-2">
                <span class="mt-avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 2))); ?></span>
                <span class="d-none d-sm-inline" style="font-size:0.88rem;">Halo, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Pengguna'); ?></strong></span>
            </div>

            <a href="actions/auth/logout.php" class="mt-logout-btn" title="Logout">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span class="d-none d-sm-inline">Logout</span>
            </a>
        </div>
    </div>

    <div class="collapse d-md-none" id="mtMobileMenu">
        <div class="container-xl pb-3 d-flex flex-column gap-1 mt-mobile-menu">
            <?php foreach ($mt_links as $l): ?>
                <a href="<?= $l['href']; ?>" class="mt-nav-link <?= $mt_active === $l['key'] ? 'active' : ''; ?>"<?= !empty($l['style']) ? ' style="' . $l['style'] . '"' : ''; ?>><?= $l['label']; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</nav>