<?php
$users = $users ?? [];
include __DIR__ . '/partials/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Money Tracker - Admin Panel</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link active" href="admin_notification.php">Kirim Notifikasi</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Kirim Notifikasi / Pengumuman Admin</h4>
                    <?php include __DIR__ . '/partials/alerts.php'; ?>

                    <form action="actions/admin/process_send_notification.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Pilih Pengguna Tujuan</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Pilih Pengguna --</option>
                                <!-- Opsi Broadcast Ke Semua Akun -->
                                <option value="all" class="fw-bold text-primary">📢 Semua Pengguna (Broadcast)</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id']; ?>">
                                        <?= htmlspecialchars($user['display_name']); ?> (<?= htmlspecialchars($user['email']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Pesan</label>
                            <input type="text" name="title" class="form-control" placeholder="Misal: Pemeliharaan Sistem" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Pesan</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Tuliskan isi pengumuman di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>