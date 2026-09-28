# 💰 MonTrack

Aplikasi web pencatat keuangan pribadi. Catat pemasukan dan pengeluaran, kelompokkan dengan kategori, lalu pantau saldo dan ringkasan keuangan Anda dalam satu dashboard.

🌐 **Demo langsung:** [montrack.gt.tc](https://montrack.gt.tc)

---

## ✨ Fitur

**Untuk pengguna**
- Registrasi dan login dengan kata sandi terenkripsi (bcrypt)
- Dashboard ringkasan: saldo, total pemasukan, dan total pengeluaran
- Grafik keuangan untuk memantau arus kas
- Tambah, ubah, dan hapus transaksi (pemasukan / pengeluaran)
- Kategori transaksi yang bisa ditambahkan sendiri
- Hapus seluruh riwayat transaksi sekaligus
- Notifikasi dari admin dengan penanda sudah dibaca
- Halaman Privasi, Ketentuan Layanan, dan Pusat Bantuan
- Tampilan modern yang responsif di desktop dan mobile

**Untuk admin**
- Dashboard admin: total pengguna dan total transaksi sistem
- Daftar seluruh pengguna terdaftar
- Kirim notifikasi ke pengguna

---

## 🛠️ Teknologi

| Bagian | Teknologi |
|---|---|
| Backend | PHP (PDO) |
| Database | MySQL / MariaDB |
| Frontend | HTML, CSS, JavaScript, Bootstrap 5 |
| Ikon & Font | Bootstrap Icons, Plus Jakarta Sans |

---

## 📁 Struktur Folder

```
money_tracker/
├── actions/          # Proses backend (auth, transaksi, notifikasi, admin)
├── assets/           # CSS dan JavaScript
├── config/           # Konfigurasi database
├── includes/         # Pengecekan login dan hak akses admin
├── sql/              # Skema database
├── views/            # Tampilan halaman
├── index.php
├── login.php
├── register.php
├── dashboard.php
└── ...
```

---

## 🚀 Instalasi (Lokal)

**Prasyarat:** PHP 8+, MySQL/MariaDB, dan web server (Laragon, XAMPP, atau sejenisnya).

1. **Clone repository**
   ```bash
   git clone https://github.com/USERNAME/REPO.git
   ```
   Letakkan folder proyek di direktori web server (misalnya `www` di Laragon atau `htdocs` di XAMPP).

2. **Buat database**
   Impor file `sql/money_tracker.sql` lewat phpMyAdmin atau terminal:
   ```bash
   mysql -u root -p < sql/money_tracker.sql
   ```

3. **Atur koneksi database**
   Buka `config/database.php` lalu sesuaikan `host`, `db_name`, `username`, dan `password` dengan pengaturan Anda.

4. **Jalankan aplikasi**
   Buka `http://localhost/nama-folder-proyek/login.php` di browser.

5. **Buat akun admin (opsional)**
   Daftar akun biasa terlebih dahulu, lalu ubah kolom `role` pada tabel `users` menjadi `admin` lewat phpMyAdmin.

---

## 🔐 Keamanan

- Kata sandi disimpan dalam bentuk hash bcrypt (`password_hash`)
- Query database memakai prepared statement (PDO) untuk mencegah SQL injection
- Halaman dashboard dan admin dilindungi pengecekan sesi dan role

---

## 🗺️ Rencana Pengembangan

- [ ] Konfirmasi kata sandi saat registrasi
- [ ] Fitur lupa kata sandi
- [ ] Ekspor laporan transaksi

---

## 👤 Pembuat

Dibuat oleh **Muhammad Eky Solehudin**

- GitHub: [@muhekyudin-sudo](https://github.com/muhekyudin-sudo)

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan belajar dan portofolio. Silakan gunakan dan kembangkan sesuai kebutuhan.
