// Custom JS - Form interaktif / validasi client-side
document.addEventListener('DOMContentLoaded', function () {
    console.log('Money Tracker app.js loaded');
    initCategoryTypeFilter();
    initExpandTables();
    initSummarySlider();
    initCategorySlider();
    initMonthlyResetToggle();
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


// Slider generik, dipakai oleh Ringkasan Bulanan/Tahunan dan Pengeluaran per Kategori.
// Cara kerja: semua slide berjejer ke samping di dalam "track".
// Untuk pindah slide, track digeser dengan translateX (animasinya diatur CSS).
//   root       = kartu pembungkus (punya atribut data-slider)
//   startIndex = slide yang tampil pertama (0 = slide pertama)
//   onChange   = fungsi opsional, dipanggil setiap slide berpindah
function setupSlider(root, startIndex, onChange) {
    var slider  = root.querySelector('.mt-slider');
    var track   = root.querySelector('.mt-slider-track');
    var slides  = root.querySelectorAll('.mt-slide');
    var dots    = root.querySelectorAll('[data-slide-dot]');
    var prevBtn = root.querySelector('[data-slider-prev]');
    var nextBtn = root.querySelector('[data-slider-next]');
    var titleEl = root.querySelector('[data-slider-title]');
    var subEl   = root.querySelector('[data-slider-sub]');
    var current = 0;

    if (!slider || !track || slides.length === 0) {
        return;
    }

    function goTo(index) {
        if (index < 0 || index > slides.length - 1) {
            return; // sudah di ujung, tidak bisa lanjut
        }
        current = index;

        // 1. Geser track
        track.style.transform = 'translateX(-' + (current * 100) + '%)';

        // 2. Tandai slide yang aktif (memicu animasi)
        slides.forEach(function (slide, i) {
            slide.classList.toggle('is-active', i === current);
        });

        // 3. Update titik indikator
        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === current);
        });

        // 4. Ganti judul / sub-judul kalau slide punya data-title / data-sub
        var title = slides[current].getAttribute('data-title');
        var sub   = slides[current].getAttribute('data-sub');
        if (titleEl && title) {
            titleEl.textContent = title;
        }
        if (subEl && sub) {
            subEl.textContent = sub;
        }

        // 5. Matikan tombol panah di ujung
        prevBtn.disabled = (current === 0);
        nextBtn.disabled = (current === slides.length - 1);

        if (onChange) {
            onChange(current);
        }
    }

    prevBtn.addEventListener('click', function () { goTo(current - 1); });
    nextBtn.addEventListener('click', function () { goTo(current + 1); });

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            goTo(parseInt(dot.getAttribute('data-slide-dot'), 10));
        });
    });

    // Swipe di HP: geser jari ke kiri = slide berikutnya
    var startX = null;
    slider.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
    }, { passive: true });

    slider.addEventListener('touchend', function (e) {
        if (startX === null) {
            return;
        }
        var diff = e.changedTouches[0].clientX - startX;
        if (Math.abs(diff) > 50) {
            goTo(current + (diff < 0 ? 1 : -1));
        }
        startX = null;
    });

    // Posisi awal langsung muncul, tanpa animasi menggeser dari slide pertama
    track.style.transition = 'none';
    goTo(startIndex || 0);
    void track.offsetHeight; // paksa browser menerapkan posisi awal dulu
    track.style.transition = '';
}

// Ringkasan Bulanan & Tahunan
function initSummarySlider() {
    var root = document.querySelector('[data-slider="summary"]');
    if (root) {
        setupSlider(root, 0);
    }
}

// Pengeluaran per Kategori: 1 slide = 1 bulan, mulai dari bulan berjalan.
// Grafik donat baru dibuat saat slide-nya tampil, jadi animasinya terlihat setiap kali.
function initCategorySlider() {
    var root = document.querySelector('[data-slider="category"]');
    if (!root || typeof Chart === 'undefined') {
        return;
    }

    var data    = window.mtCategoryData || [];
    var palette = window.mtPalette || ['#059669'];
    var charts  = {}; // grafik yang sudah dibuat, supaya tidak dibuat dua kali

    function buildChart(index) {
        if (charts[index]) {
            return;
        }
        var canvas = root.querySelector('canvas[data-month="' + index + '"]');
        if (!canvas || !data[index]) {
            return; // bulan tanpa pengeluaran: tidak ada grafik
        }

        var colors = data[index].labels.map(function (label, i) {
            return palette[i % palette.length];
        });

        charts[index] = new Chart(canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: data[index].labels,
                datasets: [{
                    data: data[index].values,
                    backgroundColor: colors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var value = Number(context.raw).toLocaleString('id-ID');
                                return context.label + ': Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    }

    setupSlider(root, window.mtCategoryStart || 0, buildChart);
}

// Saklar "Reset saldo setiap awal bulan".
// Saat DINYALAKAN: tampil peringatan dulu. Kalau pengguna batal, saklar dikembalikan.
// Saat DIMATIKAN: langsung disimpan.
function initMonthlyResetToggle() {
    document.querySelectorAll('[data-reset-form]').forEach(function (form) {
        var toggle = form.querySelector('[data-reset-toggle]');
        var hidden = form.querySelector('input[name="monthly_reset"]');

        if (!toggle || !hidden) {
            return;
        }

        toggle.addEventListener('change', function () {
            if (toggle.checked) {
                var setuju = confirm(
                    'Aktifkan reset saldo bulanan?\n\n' +
                    'Setiap tanggal 1, Total Saldo, Pemasukan, dan Pengeluaran di dashboard ' +
                    'mulai dari Rp 0 lagi.\n\n' +
                    '• Saldo bulan lalu TIDAK terbawa ke bulan baru.\n' +
                    '• Semua transaksi lama tetap aman di Riwayat dan di ' +
                    'Ringkasan Bulanan & Tahunan.\n' +
                    '• Anda bisa mematikannya kapan saja.'
                );

                if (!setuju) {
                    toggle.checked = false; // batal: kembalikan saklar
                    return;
                }
                hidden.value = '1';
            } else {
                hidden.value = '0';
            }

            form.submit();
        });
    });
}
