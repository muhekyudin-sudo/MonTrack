<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifBtn = document.getElementById('notifDropdown');
        const notifBadge = document.getElementById('notifBadge');

        if (notifBtn) {
            notifBtn.addEventListener('click', function() {
                // Hilangkan badge secara visual langsung
                if (notifBadge) {
                    notifBadge.remove();
                }

                // Simpan status "sudah dibaca" ke database
                fetch('actions/notifications/mark_as_read.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).catch(function(err) {
                    console.error('Gagal menandai notifikasi sebagai dibaca:', err);
                });
            });
        }
    });
</script>
</body>

</html>