<?php
$user_list   = $user_list ?? [];
$total_users = $total_users ?? 0;
$trx_stats   = $trx_stats ?? ['total_trx' => 0];
include __DIR__ . '/partials/header.php';
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashboard.css?v=<?= filemtime(__DIR__ . '/../assets/css/dashboard.css'); ?>">

<div class="mt-body">

    <?php $mt_area = 'admin'; $mt_active = 'admin_dashboard'; include __DIR__ . '/partials/mt_navbar.php'; ?>

    <div class="container-xl py-4">

        <div class="mb-4">
            <h1 class="mt-page-title">Dashboard Admin</h1>
            <p class="mt-section-sub mb-0">Ringkasan pengguna dan aktivitas transaksi di seluruh sistem.</p>
        </div>

        <!-- Kartu ringkasan -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="mt-card mt-stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="mt-stat-label">Total Pengguna Terdaftar</span>
                        <span class="mt-stat-icon" style="background: var(--mt-primary-soft); color: var(--mt-primary);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-stat-value"><?= $total_users; ?> <span style="font-size:1rem; font-weight:600; color:var(--mt-muted);">Pengguna</span></div>
                    <span class="mt-stat-sub">Seluruh akun yang ada di sistem</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mt-card mt-stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="mt-stat-label">Total Transaksi Sistem</span>
                        <span class="mt-stat-icon" style="background: var(--mt-orange-soft); color: #b45309;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="17 1 21 5 17 9"></polyline>
                                <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                                <polyline points="7 23 3 19 7 15"></polyline>
                                <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-stat-value"><?= $trx_stats['total_trx'] ?? 0; ?> <span style="font-size:1rem; font-weight:600; color:var(--mt-muted);">Transaksi</span></div>
                    <span class="mt-stat-sub">Gabungan seluruh transaksi pengguna</span>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Pengguna -->
        <div class="mt-card mt-table-card">
            <h5 class="mt-section-title">Daftar Pengguna Sistem</h5>
            <div class="mt-section-sub mb-3">Semua akun yang terdaftar beserta perannya</div>

            <div class="mt-table-wrap">
                <table class="mt-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_list as $u): ?>
                            <tr>
                                <td><?= $u['id']; ?></td>
                                <td>
                                    <div class="mt-user-cell">
                                        <span class="mt-avatar"><?= htmlspecialchars(strtoupper(substr($u['display_name'], 0, 2))); ?></span>
                                        <span><?= htmlspecialchars($u['display_name']); ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($u['email']); ?></td>
                                <td>
                                    <span class="mt-role-pill <?= $u['role'] === 'admin' ? 'mt-role-admin' : 'mt-role-user'; ?>">
                                        <?= strtoupper($u['role']); ?>
                                    </span>
                                </td>
                                <td><?= $u['created_at']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-table-footer">
                <span>Menampilkan <?= count($user_list); ?> pengguna</span>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/partials/mt_footer.php'; ?>

</div>

<?php include __DIR__ . '/partials/footer.php'; ?>