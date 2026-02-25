<?= $this->extend('layouts/topnav') ?>
<?= $this->section('content') ?>

<?php $activeNav = 'appointments'; ?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">My Appointments</h1>
    <p class="page-header__sub">Your complete appointment history</p>
  </div>
</div>

<?= $this->include('components/flash') ?>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Doctor</th>
          <th>Date</th>
          <th>Time</th>
          <th>Symptoms</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($appointments)): ?>
          <?php foreach ($appointments as $a): ?>
          <tr>
            <td class="td--muted"><?= esc($a['Appointmentcode']) ?></td>
            <td class="td--name"><?= esc($a['DoctorCode']) ?></td>
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
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" style="text-align:center;">No appointments found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
