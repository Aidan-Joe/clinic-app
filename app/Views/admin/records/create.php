<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'records';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Add Medical Record</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/records') ?>" class="card__action">← Back to Records</a></p>
  </div>
</div>

<div class="card" style="max-width:640px;">
  <div class="card__body">
    <form action="<?= base_url('admin/records/store') ?>" method="post">
      <?= csrf_field() ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group">
          <label class="form-label">Patient</label>
          <select name="Patientcode" class="form-control" required>
            <option value="">Select patient</option>
            <?php foreach ($patients as $p): ?>
              <option value="<?= esc($p['Patientcode']) ?>"><?= esc($p['Patient_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Doctor</label>
          <select name="DoctorCode" class="form-control" required>
            <option value="">Select doctor</option>
            <?php foreach ($doctors as $d): ?>
              <option value="<?= esc($d['DoctorCode']) ?>"><?= esc($d['Doctor_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Visit Date</label>
          <input type="date" name="Visit_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Diagnosis</label>
          <input type="text" name="Diagnosis" class="form-control" required>
        </div>
        <div class="form-group" style="grid-column:span 2;">
          <label class="form-label">Treatment</label>
          <input type="text" name="Treatment" class="form-control" required>
        </div>
        <div class="form-group" style="grid-column:span 2;">
          <label class="form-label">Prescription</label>
          <textarea name="Prescription" class="form-control" style="height:80px;" required></textarea>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Save Record</button>
        <a href="<?= base_url('admin/records') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
