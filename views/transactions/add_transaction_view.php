<?php include __DIR__ . '/../partials/header.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashboard.css?v=<?= filemtime(__DIR__ . '/../../assets/css/dashboard.css'); ?>">

<div class="mt-body">

    <?php $mt_active = 'add'; include __DIR__ . '/../partials/mt_navbar.php'; ?>

    <div class="container-xl py-4">

        <div class="mb-4">
            <h1 class="mt-page-title">Tambah Transaksi</h1>
            <p class="mt-section-sub mb-0">Catat pemasukan atau pengeluaran baru, atau buat kategori sendiri.</p>
        </div>

        <?php include __DIR__ . '/../partials/alerts.php'; ?>

        <div class="row g-4">

            <!-- ========== Form Tambah Transaksi ========== -->
            <div class="col-lg-7">
                <div class="mt-card mt-form-card">
                    <div class="mt-card-head">
                        <span class="mt-card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </span>
                        <div>
                            <h5 class="mt-section-title">Catat Transaksi Baru</h5>
                            <div class="mt-section-sub">Isi detail transaksi Anda di bawah ini</div>
                        </div>
                    </div>

                    <form action="actions/transactions/process_add_transaction.php" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="mt-label" for="transaction_type">Tipe Transaksi</label>
                                <select id="transaction_type" name="transaction_type" class="form-select mt-control" required>
                                    <option value="expense">Pengeluaran (Expense)</option>
                                    <option value="income">Pemasukan (Income)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="mt-label" for="transaction_date">Tanggal</label>
                                <input type="date" id="transaction_date" name="transaction_date" class="form-control mt-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="mt-label" for="amount">Nominal</label>
                            <div class="mt-prefix">
                                <span>Rp</span>
                                <input type="number" step="0.01" id="amount" name="amount" class="form-control mt-control" placeholder="100000" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="mt-label" for="category_id">Kategori</label>
                            <select id="category_id" name="category_id" class="form-select mt-control" required>
                                <?php if (isset($categories) && count($categories) > 0): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id']; ?>" data-type="<?= htmlspecialchars($cat['type']); ?>">
                                            <?= htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">-- Kategori Tidak Ditemukan --</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="mt-label" for="notes">Catatan</label>
                            <textarea id="notes" name="notes" class="form-control mt-control" rows="3" placeholder="Opsional, misalnya: makan siang bersama tim"></textarea>
                        </div>

                        <button type="submit" class="mt-btn-primary mt-btn-block">Simpan Transaksi</button>
                    </form>
                </div>
            </div>

            <!-- ========== Form Tambah Kategori ========== -->
            <div class="col-lg-5">
                <div class="mt-card mt-form-card">
                    <div class="mt-card-head">
                        <span class="mt-card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                        </span>
                        <div>
                            <h5 class="mt-section-title">Tambah Kategori Baru</h5>
                            <div class="mt-section-sub">Buat kategori sesuai kebutuhan Anda</div>
                        </div>
                    </div>

                    <form action="actions/transactions/process_add_category.php" method="POST">
                        <div class="mb-3">
                            <label class="mt-label" for="category_name">Nama Kategori</label>
                            <input type="text" id="category_name" name="category_name" class="form-control mt-control" placeholder="Misal: Tagihan Air" required>
                        </div>

                        <div class="mb-4">
                            <label class="mt-label" for="category_type">Tipe Kategori</label>
                            <select id="category_type" name="category_type" class="form-select mt-control" required>
                                <option value="expense">Pengeluaran</option>
                                <option value="income">Pemasukan</option>
                            </select>
                        </div>

                        <button type="submit" class="mt-btn-outline mt-btn-block">Simpan Kategori</button>

                        <div class="mt-info-note">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span>Kategori baru langsung muncul di pilihan kategori saat mencatat transaksi.</span>
                        </div>
                    </form>
                </div>

                <!-- ========== Daftar & Hapus Kategori ========== -->
                <div class="mt-card mt-form-card mt-4">
                    <div class="mt-card-head">
                        <span class="mt-card-icon" style="color: var(--mt-expense); background: var(--mt-expense-soft);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </span>
                        <div>
                            <h5 class="mt-section-title">Hapus Kategori</h5>
                            <div class="mt-section-sub">Hapus kategori buatan Anda sendiri (1 per 1)</div>
                        </div>
                    </div>

                    <?php
                    $current_user_id = $user_id ?? ($_SESSION['user_id'] ?? 0);
                    $my_custom_categories = array_filter($categories ?? [], function ($c) use ($current_user_id) {
                        return !empty($c['user_id']) && (int)$c['user_id'] === (int)$current_user_id && empty($c['is_default']);
                    });
                    ?>

                    <?php if (!empty($my_custom_categories)): ?>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 0.9rem;">
                                <tbody>
                                    <?php foreach ($my_custom_categories as $my_cat): ?>
                                        <tr>
                                            <td class="ps-0 py-2">
                                                <span class="fw-semibold text-dark"><?= htmlspecialchars($my_cat['name']); ?></span>
                                            </td>
                                            <td class="py-2 text-center" style="width: 110px;">
                                                <span class="mt-type-pill <?= $my_cat['type'] === 'income' ? 'mt-type-income' : 'mt-type-expense'; ?>" style="font-size: 0.75rem;">
                                                    <?= $my_cat['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran'; ?>
                                                </span>
                                            </td>
                                            <td class="pe-0 py-2 text-end" style="width: 80px;">
                                                <form action="actions/transactions/process_delete_category.php" method="POST" onsubmit="return confirm('Hapus kategori <?= htmlspecialchars(addslashes($my_cat['name'])); ?>? Riwayat transaksi lama Anda tidak akan terhapus.');" class="d-inline">
                                                    <input type="hidden" name="category_id" value="<?= $my_cat['id']; ?>">
                                                    <button type="submit" class="mt-btn-ghost-danger p-1" title="Hapus kategori">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        </svg>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small mb-0 py-2">Belum ada kategori buatan Anda sendiri yang dapat dihapus. (Kategori bawaan sistem tidak dapat dihapus).</p>
                    <?php endif; ?>

                    <div class="mt-info-note mt-3">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span>Menghapus kategori tidak akan menghapus catatan atau riwayat transaksi lama Anda.</span>
                    </div>
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
<script>
// Isi tanggal default dengan tanggal di perangkat pengguna (bukan tanggal server)
(function () {
    function setToday() {
        var el = document.getElementById('transaction_date');
        if (!el) return;
        var d = new Date();
        var m = ('0' + (d.getMonth() + 1)).slice(-2);
        var day = ('0' + d.getDate()).slice(-2);
        el.value = d.getFullYear() + '-' + m + '-' + day;
    }
    setToday();
    window.addEventListener('pageshow', function (e) { if (e.persisted) setToday(); });
})();
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>