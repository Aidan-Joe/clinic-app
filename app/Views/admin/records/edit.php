<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'records';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Edit Medical Record</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/records') ?>" class="card__action">← Back to Records</a></p>
  </div>
</div>

<div class="card" style="max-width:640px;">
  <div class="card__body">
    <form action="<?= base_url('admin/records/update/' . $record['RecordCode']) ?>" method="post">
      <?= csrf_field() ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group">
          <label class="form-label">Patient</label>
          <select name="Patientcode" class="form-control" required>
            <?php foreach ($patients as $p): ?>
              <option value="<?= esc($p['Patientcode']) ?>" <?= $record['Patientcode'] === $p['Patientcode'] ? 'selected' : '' ?>>
                <?= esc($p['Patient_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Doctor</label>
          <select name="DoctorCode" class="form-control" required>
            <?php foreach ($doctors as $d): ?>
              <option value="<?= esc($d['DoctorCode']) ?>" <?= $record['DoctorCode'] === $d['DoctorCode'] ? 'selected' : '' ?>>
                <?= esc($d['Doctor_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Diagnosis</label>
          <input type="text" name="Diagnosis" class="form-control" value="<?= esc($record['Diagnosis']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Treatment</label>
          <input type="text" name="Treatment" class="form-control" value="<?= esc($record['Treatment']) ?>" required>
        </div>
        <div class="form-group" style="grid-column:span 2;">
          <label class="form-label">Prescription</label>
          <textarea name="Prescription" class="form-control" style="height:80px;" required><?= esc($record['Prescription']) ?></textarea>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Update Record</button>
        <a href="<?= base_url('admin/records') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
