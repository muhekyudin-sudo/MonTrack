<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - MonTrack</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="lg-body">

<div class="lg-page">

    <!-- ========== PANEL KIRI ========== -->
    <aside class="lg-brand">
        <a href="index.php" class="lg-logo">
            <span class="lg-logo-icon"><i class="bi bi-wallet2"></i></span>
            <span>Mon<b>Track</b></span>
        </a>

        <div class="lg-brand-body">
            <span class="lg-badge"><i class="bi bi-stars"></i> Daftar Gratis</span>
            <h1 class="lg-headline">
                Mulai Perjalanan Finansial Anda
                <span>Dengan Catatan yang Rapi</span>
            </h1>
            <p class="lg-desc">
                Buat akun dalam hitungan detik, lalu catat pemasukan dan pengeluaran
                Anda kapan saja. Semua data tersimpan aman dan mudah dipantau.
            </p>
        </div>

        <div class="lg-brand-foot">
            <span><i class="bi bi-shield-check"></i>Data Aman Terlindungi</span>
            <span><i class="bi bi-lock"></i>Kata Sandi Terenkripsi</span>
        </div>
    </aside>

    <!-- ========== PANEL KANAN ========== -->
    <main class="lg-form-side">
        <div class="lg-topbar">
            Bantuan? <a href="bantuan.php">Pusat Dukungan</a>
        </div>

        <div class="lg-card-wrap">
            <div class="lg-card">
                <div class="lg-card-icon"><i class="bi bi-person-plus"></i></div>
                <h2 class="lg-title">Daftar Akun</h2>
                <p class="lg-subtitle">Buat akun baru untuk mulai mencatat keuangan Anda.</p>

                <?php include __DIR__ . '/../partials/alerts.php'; ?>

                <form action="actions/auth/process_register.php" method="POST">
                    <div class="lg-field">
                        <label for="display_name">Nama Lengkap</label>
                        <div class="lg-input">
                            <i class="bi bi-person lg-icon"></i>
                            <input type="text" id="display_name" name="display_name" placeholder="Nama lengkap Anda" autocomplete="name" required>
                        </div>
                    </div>

                    <div class="lg-field">
                        <label for="email">Email</label>
                        <div class="lg-input">
                            <i class="bi bi-envelope lg-icon"></i>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="lg-field">
                        <label for="password">Kata Sandi</label>
                        <div class="lg-input">
                            <i class="bi bi-lock lg-icon"></i>
                            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password" required>
                            <button type="button" class="lg-eye" id="togglePassword" aria-label="Tampilkan kata sandi">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="lg-submit" style="margin-top: 8px;">Daftar</button>
                </form>

                <p class="lg-register">Sudah punya akun? <a href="login.php">Masuk sekarang</a></p>
            </div>
        </div>

        <div class="lg-footer">
            <a href="privasi.php">Privasi</a><span class="dot"></span>
            <a href="ketentuan.php">Ketentuan Layanan</a><span class="dot"></span>
            <a href="bantuan.php">Bantuan</a>
        </div>
    </main>

</div>

<script>
    // Tampilkan / sembunyikan kata sandi
    document.getElementById('togglePassword').addEventListener('click', function () {
        var input = document.getElementById('password');
        var icon  = this.querySelector('i');
        var show  = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
</script>
</body>
</html>