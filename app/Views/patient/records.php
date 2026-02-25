<?= $this->extend('layouts/topnav') ?>
<?= $this->section('content') ?>

<?php $activeNav = 'records'; ?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">My Medical Records</h1>
    <p class="page-header__sub">Your complete health history</p>
  </div>
</div>

<div style="display:flex;flex-direction:column;gap:14px;">
  <?php if (!empty($records)): ?>
    <?php foreach ($records as $rec): ?>
    <div class="card">
      <div class="card__body">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
          <div>
            <span class="rec-card__code"><?= esc($rec['RecordCode']) ?></span>
            <div style="font-size:16px;font-weight:600;color:var(--gray-900);margin-top:4px;">
              <?= esc($rec['Diagnosis']) ?>
            </div>
          </div>
          <span style="font-size:12px;color:var(--gray-500);"><?= esc($rec['Visit_date']) ?></span>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
          <div>
            <div style="font-size:10px;color:var(--gray-500);text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">Treatment</div>
            <div style="font-size:13px;"><?= esc($rec['Treatment']) ?></div>
          </div>
          <div>
            <div style="font-size:10px;color:var(--gray-500);text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">Prescription</div>
            <div style="font-size:13px;">💊 <?= esc($rec['Prescription']) ?></div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="card">
      <div class="card__body" style="text-align:center;padding:32px;">No medical records found.</div>
    </div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
