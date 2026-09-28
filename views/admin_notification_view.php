<?php
$users = $users ?? [];
include __DIR__ . '/partials/header.php';
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashboard.css?v=<?= filemtime(__DIR__ . '/../assets/css/dashboard.css'); ?>">

<div class="mt-body">

    <?php $mt_area = 'admin'; $mt_active = 'admin_notification'; include __DIR__ . '/partials/mt_navbar.php'; ?>

    <div class="container-xl py-4">

        <div class="mb-4">
            <h1 class="mt-page-title">Kirim Notifikasi</h1>
            <p class="mt-section-sub mb-0">Kirim pesan atau pengumuman ke satu pengguna atau semua pengguna.</p>
        </div>

        <?php include __DIR__ . '/partials/alerts.php'; ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mt-card mt-form-card">
                    <div class="mt-card-head">
                        <span class="mt-card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </span>
                        <div>
                            <h5 class="mt-section-title">Pesan &amp; Pengumuman Admin</h5>
                            <div class="mt-section-sub">Pesan akan muncul di lonceng notifikasi pengguna</div>
                        </div>
                    </div>

                    <form action="actions/admin/process_send_notification.php" method="POST">
                        <div class="mb-3">
                            <label class="mt-label" for="user_id">Pilih Pengguna Tujuan</label>
                            <select id="user_id" name="user_id" class="form-select mt-control" required>
                                <option value="">-- Pilih Pengguna --</option>
                                <option value="all">📢 Semua Pengguna (Broadcast)</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id']; ?>">
                                        <?= htmlspecialchars($user['display_name']); ?> (<?= htmlspecialchars($user['email']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="mt-label" for="title">Judul Pesan</label>
                            <input type="text" id="title" name="title" class="form-control mt-control" placeholder="Misal: Pemeliharaan Sistem" required>
                        </div>

                        <div class="mb-4">
                            <label class="mt-label" for="message">Isi Pesan</label>
                            <textarea id="message" name="message" class="form-control mt-control" rows="5" placeholder="Tuliskan isi pengumuman di sini..." required></textarea>
                        </div>

                        <button type="submit" class="mt-btn-primary mt-btn-block">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/partials/mt_footer.php'; ?>

</div>

<?php include __DIR__ . '/partials/footer.php'; ?>