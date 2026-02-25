<?= $this->extend('layouts/topnav') ?>
<?= $this->section('content') ?>

<?php
$activeNav = 'profile';
$initials  = implode('', array_map(fn($w) => strtoupper($w[0]),
    array_slice(explode(' ', $patient['Patient_name']), 0, 2)
));
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">My Profile</h1>
    <p class="page-header__sub">Your account information</p>
  </div>
</div>

<div class="card" style="max-width:480px;">
  <div class="profile-card__head">
    <div class="avatar avatar--lg avatar--green" style="margin:0 auto;"><?= $initials ?></div>
    <div class="profile-card__name"><?= esc($patient['Patient_name']) ?></div>
    <div class="profile-card__code"><?= esc($patient['Patientcode']) ?></div>
  </div>
  <div class="detail-list">
    <div class="detail-row">
      <span>Email</span>
      <span><?= esc($patient['Patient_email']) ?></span>
    </div>
    <div class="detail-row">
      <span>Phone</span>
      <span><?= esc($patient['Phone']) ?></span>
    </div>
    <div class="detail-row">
      <span>Gender</span>
      <span><?= esc($patient['Gender']) ?></span>
    </div>
    <div class="detail-row">
      <span>Date of Birth</span>
      <span><?= date('j M Y', strtotime($patient['Birthdate'])) ?></span>
    </div>
    <div class="detail-row">
      <span>Address</span>
      <span><?= esc($patient['Address']) ?></span>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
