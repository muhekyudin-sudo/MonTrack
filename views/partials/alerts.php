<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'registered'): ?>
        <div class="alert alert-success auto-dismiss-alert">Registrasi berhasil! Silakan masuk.</div>
    <?php elseif ($_GET['status'] === 'failed'): ?>
        <div class="alert alert-danger auto-dismiss-alert">Proses gagal atau data tidak valid.</div>
    <?php elseif ($_GET['status'] === 'logged_out'): ?>
        <div class="alert alert-info auto-dismiss-alert">Anda telah keluar dari sistem.</div>
    <?php elseif ($_GET['status'] === 'trx_success'): ?>
        <div class="alert alert-success auto-dismiss-alert">Transaksi baru berhasil disimpan!</div>
    <?php elseif ($_GET['status'] === 'trx_updated'): ?>
        <div class="alert alert-success auto-dismiss-alert">Transaksi berhasil diperbarui!</div>
    <?php elseif ($_GET['status'] === 'trx_deleted'): ?>
        <div class="alert alert-warning auto-dismiss-alert">Transaksi berhasil dihapus!</div>
    <?php elseif ($_GET['status'] === 'trx_all_deleted'): ?>
        <div class="alert alert-warning auto-dismiss-alert">Semua riwayat transaksi berhasil dihapus!</div>
    <?php elseif ($_GET['status'] === 'cat_added'): ?>
        <div class="alert alert-success auto-dismiss-alert">Kategori baru berhasil ditambahkan!</div>
    <?php elseif ($_GET['status'] === 'notif_sent'): ?>
        <div class="alert alert-success auto-dismiss-alert">Notifikasi berhasil dikirim ke pengguna!</div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.auto-dismiss-alert');
            alerts.forEach(function(alertEl) {
                setTimeout(function() {
                    alertEl.style.transition = 'opacity 0.5s ease';
                    alertEl.style.opacity = '0';
                    setTimeout(function() {
                        alertEl.remove();
                    }, 500); // tunggu animasi fade selesai baru dihapus dari DOM
                }, 4000); // alert hilang setelah 4 detik
            });
        });
    </script>
<?php endif; ?>