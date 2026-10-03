<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/config/database.php';

$user_id = $_SESSION['user_id'];

// 1. Kalkulasi Total Pemasukan
$stmtIncome = $pdo->prepare("SELECT SUM(amount) AS total FROM transactions WHERE user_id = ? AND transaction_type = 'income'");
$stmtIncome->execute([$user_id]);
$total_income = $stmtIncome->fetch()['total'] ?? 0;

// 2. Kalkulasi Total Pengeluaran
$stmtExpense = $pdo->prepare("SELECT SUM(amount) AS total FROM transactions WHERE user_id = ? AND transaction_type = 'expense'");
$stmtExpense->execute([$user_id]);
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
$income_count  = count(array_filter($transactions, fn($t) => $t['transaction_type'] === 'income'));
$expense_count = count(array_filter($transactions, fn($t) => $t['transaction_type'] === 'expense'));
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

require_once __DIR__ . '/views/dashboard_view.php';