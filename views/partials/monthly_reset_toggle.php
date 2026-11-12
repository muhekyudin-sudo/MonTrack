<?php
// Saklar "Reset saldo setiap awal bulan". Dipakai di menu desktop & hamburger HP.
$monthly_reset = $monthly_reset ?? 0;
$toggle_id = 'resetToggle_' . uniqid(); // id harus unik karena saklar dipakai 2x
?>
<form method="post" action="actions/settings/process_toggle_monthly_reset.php" class="mt-reset-form" data-reset-form>
    <input type="hidden" name="monthly_reset" value="<?= $monthly_reset ? 1 : 0; ?>">
    <div class="form-check form-switch m-0">
        <input class="form-check-input" type="checkbox" role="switch"
               id="<?= $toggle_id; ?>" data-reset-toggle <?= $monthly_reset ? 'checked' : ''; ?>>
        <label class="form-check-label" for="<?= $toggle_id; ?>">Reset saldo tiap awal bulan</label>
    </div>
</form>
