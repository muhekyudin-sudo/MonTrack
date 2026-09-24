// Custom JS - Form interaktif / validasi client-side
document.addEventListener('DOMContentLoaded', function () {
    console.log('Money Tracker app.js loaded');
    initCategoryTypeFilter();
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