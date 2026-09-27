<?php include __DIR__ . '/../partials/header.php'; ?>
<link rel="stylesheet" href="assets/css/footers.css">

<div class="mt-body">
    <div class="mt-footer-page">
        <a href="dashboard.php" class="mt-back-btn">&larr; Kembali ke Dashboard</a>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-4">Ketentuan Layanan</h4>
                <p><em>Terakhir diperbarui: <?= date('d F Y'); ?></em></p>

                <h6 class="mt-4">1. Penerimaan Ketentuan</h6>
                <p>Dengan mengakses dan menggunakan aplikasi MonTrack, Anda menyetujui untuk terikat oleh seluruh ketentuan dan syarat yang berlaku di dalam halaman ini.   </p>

                <h6 class="mt-4">2. Kewajiban Pengguna</h6>
                <p>Pengguna bertanggung jawab penuh atas keakuratan data transaksi yang dimasukkan serta wajib menjaga kerahasiaan informasi akun/kata sandi masing-masing.</p>

                <h6 class="mt-4">3. Batasan Tanggung Jawab</h6>
                <p>MonTrack disediakan sebagai alat bantu pencatatan keuangan pribadi. MonTrack tidak bertanggung jawab atas kerugian finansial atau kesalahan keputusan keuangan yang disebabkan oleh kelalaian pengguna atau kesalahan input data.</p>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>