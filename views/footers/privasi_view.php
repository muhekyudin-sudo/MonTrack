<?php include __DIR__ . '/../partials/header.php'; ?>
<link rel="stylesheet" href="assets/css/footers.css">

<div class="mt-body">
    <div class="mt-footer-page">
        <a href="dashboard.php" class="mt-back-btn">&larr; Kembali ke Dashboard</a>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-4">Kebijakan Privasi</h4>
                <p><em>Terakhir diperbarui: <?= date('d F Y'); ?></em></p>

                <h6 class="mt-4">1. Data yang Kami Kumpulkan</h6>
                <p>Tulis penjelasan di sini.</p>

                <h6 class="mt-4">2. Penggunaan Data</h6>
                <p>Tulis penjelasan di sini.</p>

                <h6 class="mt-4">3. Keamanan Data</h6>
                <p>Tulis penjelasan di sini.</p>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>