<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'doctors';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Edit Doctor</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/doctors') ?>" class="card__action">← Back to Doctors</a></p>
  </div>
</div>

<div class="card" style="max-width:640px;">
  <div class="card__body">
    <form action="<?= base_url('admin/doctors/update/' . $doctor['DoctorCode']) ?>" method="post">
      <?= csrf_field() ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group">
          <label class="form-label">Doctor Code</label>
          <input type="text" class="form-control" value="<?= esc($doctor['DoctorCode']) ?>" disabled>
        </div>
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="Doctor_name" class="form-control" value="<?= esc($doctor['Doctor_name']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Specialization</label>
          <input type="text" name="Specialization" class="form-control" value="<?= esc($doctor['Specialization']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Phone</label>
          <input type="text" name="Phone" class="form-control" value="<?= esc($doctor['Phone']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="Doctor_email" class="form-control" value="<?= esc($doctor['Doctor_email']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Availability</label>
          <select name="Availability" class="form-control">
            <option value="Available"     <?= $doctor['Availability'] === 'Available'     ? 'selected' : '' ?>>Available</option>
            <option value="Not Available" <?= $doctor['Availability'] === 'Not Available' ? 'selected' : '' ?>>Not Available</option>
          </select>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Update Doctor</button>
        <a href="<?= base_url('admin/doctors') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
