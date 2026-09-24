<?php
$user_list = $user_list ?? [];
$total_users = $total_users ?? 0;
$trx_stats   = $trx_stats ?? ['total_trx' => 0];
include __DIR__ . '/partials/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="admin_dashboard.php">Money Tracker - Admin Area</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link active" href="admin_dashboard.php">Dashboard Admin</a>
            <a class="nav-link" href="admin_notification.php">Kirim Notifikasi</a>
            <a class="nav-link text-warning" href="dashboard.php">Ke Tampilan User</a>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white">Admin: <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></strong></span>
            <a href="actions/auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card bg-dark text-white shadow-sm">
                <div class="card-body">
                    <h6>Total Pengguna Terdaftar</h6>
                    <h3 class="fw-bold mb-0"><?= $total_users; ?> Pengguna</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-secondary text-white shadow-sm">
                <div class="card-body">
                    <h6>Total Transaksi Sistem</h6>
                    <h3 class="fw-bold mb-0"><?= $trx_stats['total_trx'] ?? 0; ?> Transaksi</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Daftar Pengguna Sistem</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
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
                                <td><?= htmlspecialchars($u['display_name']); ?></td>
                                <td><?= htmlspecialchars($u['email']); ?></td>
                                <td>
                                    <span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                        <?= strtoupper($u['role']); ?>
                                    </span>
                                </td>
                                <td><?= $u['created_at']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>