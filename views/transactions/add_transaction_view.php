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
                                            <?= htmlspecialchars($cat['name']); ?> (<?= strtoupper($cat['type']); ?>)
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

<?php include __DIR__ . '/../partials/footer.php'; ?>