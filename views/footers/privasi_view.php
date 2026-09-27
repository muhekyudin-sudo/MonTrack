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
                <p>MonTrack hanya mengumpulkan informasi dasar akun (seperti nama pengguna/username) serta catatan transaksi keuangan (tanggal, kategori, nominal, dan catatan) yang Anda masukkan secara mandiri ke dalam sistem.</p>

                <h6 class="mt-4">2. Penggunaan Data</h6>
                <p>Data transaksi yang Anda simpan digunakan sepenuhnya untuk menyajikan ringkasan keuangan pribadi Anda, termasuk menghitung total saldo, total pemasukan/pengeluaran, dan statistik grafik pada dashboard MonTrack. Kami tidak memperjualbelikan atau membagikan data keuangan Anda kepada pihak ketiga.</p>

                <h6 class="mt-4">3. Keamanan Data</h6>
                <p>Kami berkomitmen untuk menjaga keamanan data pribadi dan catatan keuangan Anda dengan menerapkan enkripsi serta proteksi standar pada database untuk mencegah akses tanpa izin.</p>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>