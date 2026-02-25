<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'appointments';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Edit Appointment</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/appointments') ?>" class="card__action">← Back to Appointments</a></p>
  </div>
</div>

<div class="card" style="max-width:640px;">
  <div class="card__body">
    <form action="<?= base_url('admin/appointments/update/' . $appointment['Appointmentcode']) ?>" method="post">
      <?= csrf_field() ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group">
          <label class="form-label">Appointment Code</label>
          <input type="text" class="form-control" value="<?= esc($appointment['Appointmentcode']) ?>" disabled>
        </div>
        <div class="form-group">
          <label class="form-label">Patient Code</label>
          <input type="text" class="form-control" value="<?= esc($appointment['Patientcode']) ?>" disabled>
        </div>
        <div class="form-group">
          <label class="form-label">Doctor</label>
          <select name="DoctorCode" class="form-control" required>
            <?php foreach ($doctors as $d): ?>
              <option value="<?= esc($d['DoctorCode']) ?>" <?= $appointment['DoctorCode'] === $d['DoctorCode'] ? 'selected' : '' ?>>
                <?= esc($d['Doctor_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Room</label>
          <select name="Room_Code" class="form-control">
            <option value="">No room</option>
            <?php foreach ($rooms as $r): ?>
              <option value="<?= esc($r['Room_Code']) ?>" <?= ($appointment['Room_Code'] ?? '') === $r['Room_Code'] ? 'selected' : '' ?>>
                <?= esc($r['Room_Code']) ?> — <?= esc($r['Room_Name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Date</label>
          <input type="date" name="Appointment_date" class="form-control" value="<?= esc($appointment['Appointment_date']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Time</label>
          <input type="time" name="Appointment_time" class="form-control" value="<?= esc($appointment['Appointment_time']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="Status" class="form-control">
            <option value="scheduled" <?= $appointment['Status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
            <option value="completed" <?= $appointment['Status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
            <option value="cancelled" <?= $appointment['Status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
          </select>
        </div>
        <div class="form-group" style="grid-column:span 2;">
          <label class="form-label">Symptoms / Notes</label>
          <textarea name="Symptoms" class="form-control" style="height:80px;"><?= esc($appointment['Symptoms'] ?? '') ?></textarea>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Update Appointment</button>
        <a href="<?= base_url('admin/appointments') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
