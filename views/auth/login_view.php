<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - MonTrack</title>

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
            <span class="lg-badge"><i class="bi bi-stars"></i> Pencatat Keuangan Pribadi</span>
            <h1 class="lg-headline">
                Atur Keuangan &amp; Pantau Arus Kas untuk
                <span>Masa Depan Finansial</span>
            </h1>
            <p class="lg-desc">
                Catat pemasukan dan pengeluaran Anda dengan mudah, lihat ringkasan
                keuangan secara real-time, dan capai target finansial Anda lebih cepat.
            </p>

            <div class="lg-testi">
                <div class="lg-testi-head">
                    <div class="lg-avatar">ES</div>
                    <div>
                        <div class="lg-stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="lg-quote">"Montrack membuat saya lebih disiplin mengatur pengeluaran bulanan. Semua tercatat rapi dan mudah dipantau."</p>
                    </div>
                </div>
                <div class="lg-testi-foot">
                    <span><strong>Ekyslhudin</strong> — Developer</span>
                    <span class="lg-verified"><i class="bi bi-check2-circle"></i> Terverifikasi</span>
                </div>
            </div>
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
                <div class="lg-card-icon"><i class="bi bi-person"></i></div>
                <h2 class="lg-title">Masuk Akun</h2>
                <p class="lg-subtitle">Selamat datang kembali! Silakan masukkan detail akun Anda.</p>

                <?php include __DIR__ . '/../partials/alerts.php'; ?>

                <form action="actions/auth/process_login.php" method="POST">
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
                            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
                            <button type="button" class="lg-eye" id="togglePassword" aria-label="Tampilkan kata sandi">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="lg-row">
                        <label class="lg-check">
                            <input type="checkbox" name="remember"> <span>Ingat saya</span>
                        </label>
                        <a href="#" class="lg-link">Lupa kata sandi?</a>
                    </div>

                    <button type="submit" class="lg-submit">Masuk</button>
                </form>

                <p class="lg-register">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
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