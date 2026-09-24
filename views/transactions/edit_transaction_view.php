<?php
$transaction = $transaction ?? [];
$categories = $categories ?? [];
include __DIR__ . '/../partials/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Money Tracker</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="add_transaction.php">Tambah Transaksi</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Edit Transaksi</h5>
                    <form action="actions/transactions/process_edit_transaction.php" method="POST">
                        <input type="hidden" name="transaction_id" value="<?= $transaction['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Tipe Transaksi</label>
                            <select name="transaction_type" class="form-select" required>
                                <option value="expense" <?= $transaction['transaction_type'] === 'expense' ? 'selected' : ''; ?>>Pengeluaran (Expense)</option>
                                <option value="income" <?= $transaction['transaction_type'] === 'income' ? 'selected' : ''; ?>>Pemasukan (Income)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nominal (Rp)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="<?= $transaction['amount']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id']; ?>" data-type="<?= htmlspecialchars($cat['type']); ?>" <?= $cat['id'] == $transaction['category_id'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($cat['name']); ?> (<?= strtoupper($cat['type']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control" value="<?= $transaction['transaction_date']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="2"><?= htmlspecialchars($transaction['notes'] ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-fill">Update Transaksi</button>
                            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>