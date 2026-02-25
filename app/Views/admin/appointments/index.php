<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'appointments';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Appointments</h1>
    <p class="page-header__sub">Today's schedule — <?= date('l, j F Y') ?></p>
  </div>
  <div class="page-header__actions">
    <a href="<?= base_url('admin/appointments/create') ?>" class="btn btn--primary">＋ New Appointment</a>
  </div>
</div>

<?= $this->include('components/flash') ?>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Patient</th>
          <th>Doctor</th>
          <th>Room</th>
          <th>Date</th>
          <th>Time</th>
          <th>Symptoms</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($appointments)): ?>
          <?php foreach ($appointments as $a): ?>
          <tr>
            <td class="td--muted"><?= esc($a['Appointmentcode']) ?></td>
            <td>
              <div class="td--name"><?= esc($a['patient_name'] ?? $a['Patientcode']) ?></div>
              <div class="td--muted"><?= esc($a['Patientcode']) ?></div>
            </td>
            <td>
              <div><?= esc($a['doctor_name'] ?? $a['DoctorCode']) ?></div>
              <div class="td--muted"><?= esc($a['spec'] ?? '') ?></div>
            </td>
            <td class="td--muted"><?= esc($a['room'] ?? $a['Room_Code'] ?? '—') ?></td>
            <td class="td--muted"><?= esc($a['Appointment_date']) ?></td>
            <td class="td--muted"><?= esc($a['Appointment_time']) ?></td>
            <td class="td--muted" style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
              <?= esc($a['Symptoms'] ?? '—') ?>
            </td>
            <td>
              <span class="badge badge--<?= esc($a['Status']) ?>">
                <?= ucfirst($a['Status']) ?>
              </span>
            </td>
            <td>
              <div style="display:flex;gap:8px;">
                <a href="<?= base_url('admin/appointments/edit/' . $a['Appointmentcode']) ?>" class="btn btn--ghost" style="padding:6px 12px;font-size:12px;">Edit</a>
                <a href="<?= base_url('admin/appointments/delete/' . $a['Appointmentcode']) ?>"
                   class="btn btn--ghost" style="padding:6px 12px;font-size:12px;color:var(--danger);"
                   onclick="return confirm('Delete this appointment?')">Delete</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="9" style="text-align:center;">No appointments found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
