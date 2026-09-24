<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Money Tracker</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link active" href="add_transaction.php">Tambah Transaksi</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="row">
        <!-- Form Tambah Transaksi -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Catat Transaksi Baru</h5>
                    <form action="actions/transactions/process_add_transaction.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tipe Transaksi</label>
                            <select name="transaction_type" class="form-select" required>
                                <option value="expense">Pengeluaran (Expense)</option>
                                <option value="income">Pemasukan (Income)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nominal (Rp)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="100000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
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
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Transaksi</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Form Tambah Kategori Baru -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tambah Kategori Baru</h5>
                    <form action="actions/transactions/process_add_category.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="category_name" class="form-control" placeholder="Misal: Tagihan Air" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Kategori</label>
                            <select name="category_type" class="form-select" required>
                                <option value="expense">Pengeluaran</option>
                                <option value="income">Pemasukan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100">Simpan Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>