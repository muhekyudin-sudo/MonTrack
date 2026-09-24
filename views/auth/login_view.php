<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="card auth-card shadow-sm">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">Masuk Akun</h4>
            <?php include __DIR__ . '/../partials/alerts.php'; ?>
            <form action="actions/auth/process_login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
            <div class="text-center mt-3">
                <small>Belum punya akun? <a href="register.php">Daftar</a></small>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>