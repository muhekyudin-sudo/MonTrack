<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/config/database.php';

$user_id = $_SESSION['user_id'];

// 0. Pengaturan: reset saldo setiap awal bulan (0 = mati, 1 = aktif)
$stmtSetting = $pdo->prepare("SELECT monthly_reset FROM users WHERE id = ?");
$stmtSetting->execute([$user_id]);
$monthly_reset = (int)($stmtSetting->fetchColumn() ?: 0);

// Rentang tanggal bulan ini (zona waktu WIB sudah diatur di session_init.php)
$month_start = date('Y-m-01');
$month_end   = date('Y-m-t');

// Kalau reset aktif, total hanya menghitung transaksi bulan ini
$date_filter = '';
$date_params = [];
if ($monthly_reset) {
    $date_filter = " AND transaction_date BETWEEN ? AND ?";
    $date_params = [$month_start, $month_end];
}

// 1. Kalkulasi Total Pemasukan
$stmtIncome = $pdo->prepare("SELECT SUM(amount) AS total FROM transactions WHERE user_id = ? AND transaction_type = 'income'" . $date_filter);
$stmtIncome->execute(array_merge([$user_id], $date_params));
$total_income = $stmtIncome->fetch()['total'] ?? 0;

// 2. Kalkulasi Total Pengeluaran
$stmtExpense = $pdo->prepare("SELECT SUM(amount) AS total FROM transactions WHERE user_id = ? AND transaction_type = 'expense'" . $date_filter);
$stmtExpense->execute(array_merge([$user_id], $date_params));
$total_expense = $stmtExpense->fetch()['total'] ?? 0;

// 3. Hitung Total Saldo
$total_balance = $total_income - $total_expense;

// 4. Ambil Riwayat Transaksi (JOIN dengan Tabel Categories)
$stmtTransactions = $pdo->prepare("
    SELECT t.*, c.name AS category_name 
    FROM transactions t 
    JOIN categories c ON t.category_id = c.id 
    WHERE t.user_id = ? 
    ORDER BY t.transaction_date DESC, t.id DESC
");
$stmtTransactions->execute([$user_id]);
$transactions = $stmtTransactions->fetchAll();

// 5. Ambil Notifikasi dari Admin
$stmtNotif = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmtNotif->execute([$user_id]);
$notifications = $stmtNotif->fetchAll();

// 5b. Hitung notifikasi yang belum dibaca (untuk badge)
$stmtUnread = $pdo->prepare("SELECT COUNT(*) AS unread FROM notifications WHERE user_id = ? AND is_read = 0");
$stmtUnread->execute([$user_id]);
$unread_count = $stmtUnread->fetch()['unread'] ?? 0;

// 6. Ambil Total Pengeluaran per Kategori (untuk grafik)
$stmtCategory = $pdo->prepare("
    SELECT c.name AS category_name, SUM(t.amount) AS total
    FROM transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ? AND t.transaction_type = 'expense'
    GROUP BY c.name
    ORDER BY total DESC
");
$stmtCategory->execute([$user_id]);
$expenseByCategory = $stmtCategory->fetchAll();

$chartLabels = array_column($expenseByCategory, 'category_name');
$chartValues = array_map('floatval', array_column($expenseByCategory, 'total'));

// 7. Statistik tambahan untuk kartu ringkasan
$counted_trx = $monthly_reset
    ? array_filter($transactions, fn($t) => $t['transaction_date'] >= $month_start && $t['transaction_date'] <= $month_end)
    : $transactions;
$income_count  = count(array_filter($counted_trx, fn($t) => $t['transaction_type'] === 'income'));
$expense_count = count(array_filter($counted_trx, fn($t) => $t['transaction_type'] === 'expense'));
$expense_pct_of_income = $total_income > 0 ? round(($total_expense / $total_income) * 100, 2) : 0;
// 8. Kategori pengeluaran terbesar (untuk keterangan di bawah grafik)
$top_category_name = $chartLabels[0] ?? null;
$total_chart_expense = array_sum($chartValues);
$top_category_pct = ($top_category_name && $total_chart_expense > 0)
    ? round(($chartValues[0] / $total_chart_expense) * 100, 1)
    : 0;

// 9. Tanggal transaksi terakhir (untuk "Terakhir diperbarui")
$bulan_id = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
if (!empty($transactions)) {
    $ts = strtotime($transactions[0]['transaction_date']);
    $last_updated_label = date('d', $ts) . ' ' . $bulan_id[(int)date('n', $ts)] . ' ' . date('Y', $ts);
} else {
    $last_updated_label = '-';
}

// 10. Ringkasan Harian (GROUP BY tanggal + GROUP_CONCAT rincian pengeluaran)
$pdo->exec("SET SESSION group_concat_max_len = 8192"); // default 1024 bisa memotong data

$stmtDaily = $pdo->prepare("
    SELECT
        t.transaction_date,
        SUM(CASE WHEN t.transaction_type = 'income'  THEN t.amount ELSE 0 END) AS day_income,
        SUM(CASE WHEN t.transaction_type = 'expense' THEN t.amount ELSE 0 END) AS day_expense,
        GROUP_CONCAT(
            CASE WHEN t.transaction_type = 'expense'
                 THEN CONCAT(t.amount, '::', COALESCE(c.name, 'Tanpa kategori'))
            END
            ORDER BY t.id
            SEPARATOR '||'
        ) AS expense_detail
    FROM transactions t
    LEFT JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ?
    GROUP BY t.transaction_date
    ORDER BY t.transaction_date DESC
    LIMIT 30
");
$stmtDaily->execute([$user_id]);
$dailyRows = $stmtDaily->fetchAll();

$hari_id = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

$daily_summary = [];
foreach ($dailyRows as $row) {
    $ts = strtotime($row['transaction_date']);

    // Pecah "233.00::Transportasi||344.00::Hiburan" menjadi array rincian
    $details = [];
    if (!empty($row['expense_detail'])) {
        foreach (explode('||', $row['expense_detail']) as $item) {
            [$amt, $cat] = array_pad(explode('::', $item, 2), 2, '');
            $details[] = ['amount' => (float)$amt, 'category' => $cat];
        }
    }

    $daily_summary[] = [
        'day_name'   => $hari_id[(int)date('w', $ts)],
        'date_label' => date('d', $ts) . ' ' . $bulan_id[(int)date('n', $ts)] . ' ' . date('Y', $ts),
        'income'     => (float)$row['day_income'],
        'expense'    => (float)$row['day_expense'],
        'net'        => (float)$row['day_income'] - (float)$row['day_expense'],
        'details'    => $details,
    ];
}

// 11. Ringkasan Bulanan (12 bulan) & Ringkasan Tahunan (4 tahun)
// Tahun awal bisa diganti lewat alamat: dashboard.php?year=2025
$summary_year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
if ($summary_year < 2000 || $summary_year > 2100) {
    $summary_year = (int)date('Y');
}
$year_end = $summary_year + 3; // 4 tahun: misal 2026 - 2029

$bulan_full = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

// --- Bulanan: total per bulan di tahun terpilih ---
$stmtMonthly = $pdo->prepare("
    SELECT
        MONTH(transaction_date) AS m,
        SUM(CASE WHEN transaction_type = 'income'  THEN amount ELSE 0 END) AS income,
        SUM(CASE WHEN transaction_type = 'expense' THEN amount ELSE 0 END) AS expense
    FROM transactions
    WHERE user_id = ? AND YEAR(transaction_date) = ?
    GROUP BY MONTH(transaction_date)
");
$stmtMonthly->execute([$user_id, $summary_year]);
$monthlyRows = $stmtMonthly->fetchAll();

// Siapkan 12 bulan dengan nilai 0 (supaya bulan kosong tetap tampil)
$monthly_summary = [];
for ($m = 1; $m <= 12; $m++) {
    $monthly_summary[$m] = ['label' => $bulan_full[$m], 'income' => 0.0, 'expense' => 0.0, 'net' => 0.0];
}
foreach ($monthlyRows as $row) {
    $m = (int)$row['m'];
    $monthly_summary[$m]['income']  = (float)$row['income'];
    $monthly_summary[$m]['expense'] = (float)$row['expense'];
}
foreach ($monthly_summary as $m => $data) {
    $monthly_summary[$m]['net'] = $data['income'] - $data['expense'];
}

// --- Tahunan: total per tahun (4 tahun berurutan) ---
$stmtYearly = $pdo->prepare("
    SELECT
        YEAR(transaction_date) AS y,
        SUM(CASE WHEN transaction_type = 'income'  THEN amount ELSE 0 END) AS income,
        SUM(CASE WHEN transaction_type = 'expense' THEN amount ELSE 0 END) AS expense
    FROM transactions
    WHERE user_id = ? AND YEAR(transaction_date) BETWEEN ? AND ?
    GROUP BY YEAR(transaction_date)
");
$stmtYearly->execute([$user_id, $summary_year, $year_end]);
$yearlyRows = $stmtYearly->fetchAll();

$yearly_summary = [];
for ($y = $summary_year; $y <= $year_end; $y++) {
    $yearly_summary[$y] = ['label' => (string)$y, 'income' => 0.0, 'expense' => 0.0, 'net' => 0.0];
}
foreach ($yearlyRows as $row) {
    $y = (int)$row['y'];
    $yearly_summary[$y]['income']  = (float)$row['income'];
    $yearly_summary[$y]['expense'] = (float)$row['expense'];
}
foreach ($yearly_summary as $y => $data) {
    $yearly_summary[$y]['net'] = $data['income'] - $data['expense'];
}

// 12. Pengeluaran per kategori, dipisah per bulan (untuk slide grafik donat)
$stmtCatMonth = $pdo->prepare("
    SELECT
        MONTH(t.transaction_date) AS m,
        c.name AS category_name,
        SUM(t.amount) AS total
    FROM transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ? AND t.transaction_type = 'expense' AND YEAR(t.transaction_date) = ?
    GROUP BY MONTH(t.transaction_date), c.name
    ORDER BY m ASC, total DESC
");
$stmtCatMonth->execute([$user_id, $summary_year]);
$catMonthRows = $stmtCatMonth->fetchAll();

// Siapkan 12 bulan (kosong dulu), lalu isi dari hasil query
$cat_by_month = [];
for ($m = 1; $m <= 12; $m++) {
    $cat_by_month[$m] = ['labels' => [], 'values' => [], 'total' => 0.0];
}
foreach ($catMonthRows as $row) {
    $m = (int)$row['m'];
    $cat_by_month[$m]['labels'][] = $row['category_name'];
    $cat_by_month[$m]['values'][] = (float)$row['total'];
    $cat_by_month[$m]['total']   += (float)$row['total'];
}

// Slide yang tampil pertama: bulan berjalan (kalau tahun yang dilihat = tahun ini), selain itu Januari
$cat_start_index = ($summary_year === (int)date('Y')) ? ((int)date('n') - 1) : 0;

require_once __DIR__ . '/views/dashboard_view.php';