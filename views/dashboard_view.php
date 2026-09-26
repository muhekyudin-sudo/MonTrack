<?php
$total_balance = $total_balance ?? 0;
$total_income = $total_income ?? 0;
$total_expense = $total_expense ?? 0;
$notifications = $notifications ?? [];
$unread_count = $unread_count ?? 0;
$transactions = $transactions ?? [];
$chartLabels = $chartLabels ?? [];
$chartValues = $chartValues ?? [];
$income_count = $income_count ?? 0;
$expense_count = $expense_count ?? 0;
$expense_pct_of_income = $expense_pct_of_income ?? 0;
$top_category_name = $top_category_name ?? null;
$top_category_pct = $top_category_pct ?? 0;
$last_updated_label = $last_updated_label ?? '-';
$total_chart_expense = $total_chart_expense ?? array_sum($chartValues);

// Palet warna berurutan untuk badge kategori & donut chart
$mt_palette = ['#e11d48', '#f59e0b', '#4f46e5', '#10b981', '#0ea5e9', '#8b5cf6', '#ec4899', '#64748b'];

include __DIR__ . '/partials/header.php';
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashboard.css">

<div class="mt-body">

    <!-- Navbar -->
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
                <a href="dashboard.php" class="d-flex align-items-center gap-2 text-decoration-none">
                    <span class="mt-logo-badge">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="3"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </span>
                    <span class="mt-logo-text">Mon<span class="mt-accent">Track</span></span>
                </a>
                <div class="d-none d-md-flex align-items-center gap-1">
                    <a href="dashboard.php" class="mt-nav-link active">Dashboard</a>
                    <a href="add_transaction.php" class="mt-nav-link">Tambah Transaksi</a>
                    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                        <a href="admin_dashboard.php" class="mt-nav-link" style="color:#f59e0b;">Admin Panel</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 gap-sm-3">
                <div class="dropdown">
                    <button class="mt-icon-btn" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <?php if ($unread_count > 0): ?><span id="notifBadge" class="mt-dot"></span><?php endif; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end p-3 shadow border-0 mt-2" aria-labelledby="notifDropdown" style="width: 320px; max-height: 400px; overflow-y: auto; border-radius: 14px;">
                        <li class="fw-bold border-bottom pb-2 mb-2">Pesan & Pengumuman Admin</li>
                        <?php if (empty($notifications)): ?>
                            <li class="text-muted small text-center py-2">Tidak ada notifikasi.</li>
                        <?php else: ?>
                            <?php foreach ($notifications as $notif): ?>
                                <li class="mb-2 pb-2 border-bottom">
                                    <strong class="d-block text-primary small"><?= htmlspecialchars($notif['title']); ?></strong>
                                    <span class="d-block small text-dark"><?= htmlspecialchars($notif['message']); ?></span>
                                    <small class="text-muted" style="font-size: 0.75rem;"><?= $notif['created_at']; ?></small>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

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
                <a href="dashboard.php" class="mt-nav-link active">Dashboard</a>
                <a href="add_transaction.php" class="mt-nav-link">Tambah Transaksi</a>
                <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                    <a href="admin_dashboard.php" class="mt-nav-link" style="color:#f59e0b;">Admin Panel</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container-xl py-4">
        <?php include __DIR__ . '/partials/alerts.php'; ?>

        <!-- Kartu Ringkasan Finansial -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="mt-card mt-stat-card h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="mt-stat-label">Total Saldo</span>
                        <span class="mt-stat-icon" style="background: var(--mt-primary-soft); color: var(--mt-primary);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="3"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-stat-value">Rp <?= number_format($total_balance, 2, ',', '.'); ?></div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="mt-pill" style="background: var(--mt-primary-soft); color: var(--mt-primary);">Net</span>
                        <span class="mt-stat-sub">Total keuangan saat ini</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="mt-card mt-stat-card h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="mt-stat-label">Total Pemasukan</span>
                        <span class="mt-stat-icon" style="background: var(--mt-income-soft); color: var(--mt-income);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <polyline points="19 12 12 19 5 12"></polyline>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-stat-value" style="color: var(--mt-income);">Rp <?= number_format($total_income, 2, ',', '.'); ?></div>
                    <div class="d-flex align-items-center gap-2 mt-stat-meta">
                        <span class="mt-pill" style="background: var(--mt-income-soft); color: var(--mt-income);"><?= $income_count; ?> Transaksi</span>
                        <span class="mt-stat-sub">Total pemasukan</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="mt-card mt-stat-card h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="mt-stat-label">Total Pengeluaran</span>
                        <span class="mt-stat-icon" style="background: var(--mt-expense-soft); color: var(--mt-expense);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="19" x2="12" y2="5"></line>
                                <polyline points="5 12 12 5 19 12"></polyline>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-stat-value" style="color: var(--mt-expense);">Rp <?= number_format($total_expense, 2, ',', '.'); ?></div>
                    <div class="d-flex align-items-center gap-2 mt-stat-meta">
                        <span class="mt-pill" style="background: var(--mt-expense-soft); color: var(--mt-expense);"><?= $expense_count; ?> Transaksi</span>
                        <span class="mt-stat-sub"><?= $total_income > 0 ? $expense_pct_of_income . '% dari total pemasukan' : 'Belum ada pemasukan'; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Tabel Riwayat Transaksi -->
            <div class="col-lg-8">
                <div class="mt-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <div>
                            <div class="mt-section-title">Riwayat Transaksi</div>
                            <div class="mt-section-sub">Daftar aktivitas keuangan dan mutasi terbaru</div>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <a href="add_transaction.php" class="mt-btn-primary">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Transaksi Baru
                            </a>
                            <?php if (!empty($transactions)): ?>
                                <a href="actions/transactions/process_delete_all_transactions.php"
                                    class="mt-btn-ghost-danger"
                                    onclick="return confirm('PERINGATAN!\n\nSemua riwayat transaksi Anda akan dihapus secara permanen dan tidak dapat dikembalikan. Yakin ingin melanjutkan?')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                        <path d="M10 11v6"></path>
                                        <path d="M14 11v6"></path>
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                    </svg>
                                    Hapus Semua Riwayat
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="mt-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Catatan</th>
                                    <th>Tipe</th>
                                    <th class="text-end">Nominal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transactions)): ?>
                                    <?php foreach ($transactions as $i => $trx): ?>
                                        <?php $dotColor = $mt_palette[$i % count($mt_palette)]; ?>
                                        <tr>
                                            <td><?= htmlspecialchars($trx['transaction_date']); ?></td>
                                            <td>
                                                <span class="mt-cat-badge">
                                                    <span class="mt-cat-dot" style="background: <?= $dotColor; ?>;"></span>
                                                    <?= htmlspecialchars($trx['category_name']); ?>
                                                </span>
                                            </td>
                                            <td class="text-muted"><?= htmlspecialchars($trx['notes'] ?: '-'); ?></td>
                                            <td>
                                                <?php if ($trx['transaction_type'] === 'income'): ?>
                                                    <span class="mt-type-pill mt-type-income">Pemasukan</span>
                                                <?php else: ?>
                                                    <span class="mt-type-pill mt-type-expense">Pengeluaran</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end <?= $trx['transaction_type'] === 'income' ? 'mt-amount-income' : 'mt-amount-expense'; ?>">
                                                <?= $trx['transaction_type'] === 'income' ? '+' : '-'; ?>
                                                Rp <?= number_format($trx['amount'], 2, ',', '.'); ?>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="edit_transaction.php?id=<?= $trx['id']; ?>" class="mt-action-btn" title="Edit">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="actions/transactions/process_delete_transaction.php?id=<?= $trx['id']; ?>"
                                                        class="mt-action-btn danger" title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                                            <path d="M10 11v6"></path>
                                                            <path d="M14 11v6"></path>
                                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada catatan transaksi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-table-footer">
                        <span>Menampilkan <?= count($transactions); ?> dari <?= count($transactions); ?> transaksi</span>
                        <span>Terakhir diperbarui: <?= htmlspecialchars($last_updated_label); ?></span>
                    </div>
                </div>
            </div>

            <!-- Grafik Pengeluaran per Kategori -->
            <div class="col-lg-4">
                <div class="mt-card p-4 h-100">
                    <div class="mt-section-title">Pengeluaran per Kategori</div>
                    <div class="mt-section-sub mb-3">Komposisi alokasi dana belanja</div>

                    <?php if (!empty($chartLabels)): ?>
                        <div class="mt-donut-wrap">
                            <canvas id="expenseChart"></canvas>
                            <div class="mt-donut-center">
                                <span class="mt-donut-center-label">Total</span>
                                <span class="mt-donut-center-value">Rp <?= number_format(array_sum($chartValues), 0, ',', '.'); ?></span>
                            </div>
                        </div>

                        <div class="mt-legend mt-4">
                            <?php foreach ($chartLabels as $i => $label): ?>
                                <?php
                                $val = $chartValues[$i];
                                $pct = $total_chart_expense > 0 ? round(($val / $total_chart_expense) * 100, 1) : 0;
                                $color = $mt_palette[$i % count($mt_palette)];
                                ?>
                                <div class="mt-legend-row">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mt-cat-dot" style="background: <?= $color; ?>; width:10px; height:10px;"></span>
                                        <div>
                                            <div class="mt-legend-name"><?= htmlspecialchars($label); ?></div>
                                            <div class="mt-legend-amount">Rp <?= number_format($val, 0, ',', '.'); ?></div>
                                        </div>
                                    </div>
                                    <span class="mt-legend-pct"><?= $pct; ?>%</span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($top_category_name): ?>
                            <div class="mt-info-note">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <span>Porsi terbesar dialokasikan untuk <?= htmlspecialchars($top_category_name); ?>.</span>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted text-center mb-0 py-4">Belum ada data pengeluaran untuk ditampilkan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-footer">
        <div class="container-xl d-flex justify-content-between align-items-center">
            <span>&copy; <?= date('Y'); ?> MonTrack. Seluruh hak cipta dilindungi.</span>
            <div>
                <a href="bantuan.php">Bantuan</a>
                <a href="privasi.php">Privasi</a>
                <a href="ketentuan.php">Ketentuan</a>
            </div>
        </div>
    </footer>

</div>

<?php if (!empty($chartLabels)): ?>
    <!-- Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('expenseChart').getContext('2d');

        const chartLabels = <?= json_encode($chartLabels); ?>;
        const chartValues = <?= json_encode($chartValues); ?>;
        const chartColors = <?= json_encode(array_slice($mt_palette, 0, count($chartLabels))); ?>;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartValues,
                    backgroundColor: chartColors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = Number(context.raw).toLocaleString('id-ID');
                                return context.label + ': Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>