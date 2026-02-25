<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'doctor';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">My Appointments</h1>
    <p class="page-header__sub">All your scheduled and past appointments</p>
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
          <th>Date</th>
          <th>Time</th>
          <th>Symptoms</th>
          <th>Status</th>
          <th>Update Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($appointments)): ?>
          <?php foreach ($appointments as $a): ?>
          <tr>
            <td class="td--muted"><?= esc($a['Appointmentcode']) ?></td>
            <td>
              <div class="td--name"><?= esc($a['Patient_name'] ?? $a['Patientcode']) ?></div>
              <div class="td--muted"><?= esc($a['Patientcode']) ?></div>
            </td>
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
              <form action="<?= base_url('doctor/appointments/update/' . $a['Appointmentcode']) ?>" method="post" style="display:flex;gap:6px;">
                <?= csrf_field() ?>
                <select name="Status" class="form-control" style="padding:5px 8px;font-size:12px;width:auto;">
                  <option value="scheduled" <?= $a['Status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                  <option value="completed" <?= $a['Status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                  <option value="cancelled" <?= $a['Status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
                <button type="submit" class="btn btn--ghost" style="padding:5px 10px;font-size:12px;">Save</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center;">No appointments found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
