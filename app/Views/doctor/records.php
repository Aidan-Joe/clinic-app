<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'doctor';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Medical Records</h1>
    <p class="page-header__sub">Records you have created</p>
  </div>
  <div class="page-header__actions">
    <a href="<?= base_url('doctor/records/create') ?>" class="btn btn--primary">＋ New Record</a>
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
          <th>Visit Date</th>
          <th>Diagnosis</th>
          <th>Treatment</th>
          <th>Prescription</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($records)): ?>
          <?php foreach ($records as $r): ?>
          <tr>
            <td class="td--muted"><?= esc($r['RecordCode']) ?></td>
            <td>
              <div class="td--name"><?= esc($r['Patient_name'] ?? $r['Patientcode']) ?></div>
              <div class="td--muted"><?= esc($r['Patientcode']) ?></div>
            </td>
            <td class="td--muted"><?= esc($r['Visit_date']) ?></td>
            <td><?= esc($r['Diagnosis']) ?></td>
            <td class="td--muted"><?= esc($r['Treatment']) ?></td>
            <td class="td--muted" style="max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
              <?= esc($r['Prescription']) ?>
            </td>
            <td>
              <a href="<?= base_url('doctor/records/edit/' . $r['RecordCode']) ?>" class="btn btn--ghost" style="padding:6px 12px;font-size:12px;">Edit</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center;">No records found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
