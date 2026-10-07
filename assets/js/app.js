// Custom JS - Form interaktif / validasi client-side
document.addEventListener('DOMContentLoaded', function () {
    console.log('Money Tracker app.js loaded');
    initCategoryTypeFilter();
    initExpandTables();
});

// Filter opsi kategori supaya cuma menampilkan kategori yang tipenya
// sesuai dengan Tipe Transaksi yang sedang dipilih (expense/income).
// Dipakai di form Tambah Transaksi maupun Edit Transaksi.
function initCategoryTypeFilter() {
    document.querySelectorAll('form').forEach(function (form) {
        var typeSelect = form.querySelector('select[name="transaction_type"]');
        var categorySelect = form.querySelector('select[name="category_id"]');

        if (!typeSelect || !categorySelect) {
            return;
        }

        function applyFilter() {
            var selectedType = typeSelect.value;
            var previousValue = categorySelect.value;
            var hasVisibleSelected = false;

            Array.prototype.forEach.call(categorySelect.options, function (option) {
                if (!option.value) {
                    option.hidden = false;
                    option.disabled = false;
                    return;
                }

                var isMatch = option.getAttribute('data-type') === selectedType;
                option.hidden = !isMatch;
                option.disabled = !isMatch;

                if (isMatch && option.value === previousValue) {
                    hasVisibleSelected = true;
                }
            });

            if (!hasVisibleSelected) {
                var firstMatch = Array.prototype.find.call(categorySelect.options, function (opt) {
                    return opt.value && !opt.hidden;
                });
                categorySelect.value = firstMatch ? firstMatch.value : '';
            }
        }

        typeSelect.addEventListener('change', applyFilter);
        applyFilter();
    });
}

// Tombol "Tampilkan semua" untuk tabel Ringkasan Harian & Riwayat Transaksi.
// Tabel dibatasi tingginya (scroll di dalam kartu); klik tombol untuk
// menampilkan seluruh baris tanpa scroll. Tombol otomatis disembunyikan
// kalau isi tabel memang belum melebihi batas tinggi.
function initExpandTables() {
    document.querySelectorAll('[data-expand-target]').forEach(function (btn) {
        var target = document.getElementById(btn.getAttribute('data-expand-target'));
        if (!target) {
            return;
        }

        var textEl = btn.querySelector('.mt-expand-text');

        function refresh() {
            if (target.classList.contains('is-expanded')) {
                btn.hidden = false;
                return;
            }
            btn.hidden = target.scrollHeight <= target.clientHeight + 1;
        }

        btn.addEventListener('click', function () {
            var expanded = target.classList.toggle('is-expanded');
            btn.classList.toggle('is-open', expanded);
            textEl.textContent = btn.getAttribute(expanded ? 'data-label-close' : 'data-label-open');
            if (!expanded) {
                target.scrollTop = 0;
            }
        });

        window.addEventListener('resize', refresh);
        refresh();
    });
}