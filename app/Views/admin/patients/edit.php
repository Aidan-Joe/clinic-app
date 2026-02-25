<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'patients';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Edit Patient</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/patients') ?>" class="card__action">← Back to Patients</a></p>
  </div>
</div>

<div class="card" style="max-width:640px;">
  <div class="card__body">
    <form action="<?= base_url('admin/patients/update/' . $patient['Patientcode']) ?>" method="post">
      <?= csrf_field() ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group">
          <label class="form-label">Patient Code</label>
          <input type="text" class="form-control" value="<?= esc($patient['Patientcode']) ?>" disabled>
        </div>
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="Patient_name" class="form-control" value="<?= esc($patient['Patient_name']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="Patient_email" class="form-control" value="<?= esc($patient['Patient_email']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Phone</label>
          <input type="text" name="Phone" class="form-control" value="<?= esc($patient['Phone']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Gender</label>
          <select name="Gender" class="form-control">
            <option value="Male"   <?= $patient['Gender'] === 'Male'   ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $patient['Gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Date of Birth</label>
          <input type="date" name="Birthdate" class="form-control" value="<?= esc($patient['Birthdate']) ?>" required>
        </div>
        <div class="form-group" style="grid-column:span 2;">
          <label class="form-label">Address</label>
          <input type="text" name="Address" class="form-control" value="<?= esc($patient['Address']) ?>" required>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Update Patient</button>
        <a href="<?= base_url('admin/patients') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
