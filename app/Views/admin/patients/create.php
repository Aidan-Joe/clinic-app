<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'patients';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Add Patient</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/patients') ?>" class="card__action">← Back to Patients</a></p>
  </div>
</div>

<div class="card" style="max-width:640px;">
  <div class="card__body">
    <form action="<?= base_url('admin/patients/store') ?>" method="post">
      <?= csrf_field() ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group">
          <label class="form-label">Patient Code</label>
          <input type="text" name="Patientcode" class="form-control" placeholder="PT009" required>
        </div>
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="Patient_name" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="Patient_email" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="Password" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">Phone</label>
          <input type="text" name="Phone" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">Gender</label>
          <select name="Gender" class="form-control" required>
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Date of Birth</label>
          <input type="date" name="Birthdate" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">Address</label>
          <input type="text" name="Address" class="form-control" required>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Save Patient</button>
        <a href="<?= base_url('admin/patients') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
