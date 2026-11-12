-- Jalankan SEKALI di phpMyAdmin (tab SQL) pada database hosting dan database lokal.
-- 0 = reset saldo bulanan mati (bawaan), 1 = aktif
ALTER TABLE `users`
  ADD COLUMN `monthly_reset` TINYINT(1) NOT NULL DEFAULT 0 AFTER `role`;
