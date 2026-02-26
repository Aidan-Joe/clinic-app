<?= $this->extend('layouts/topnav') ?>
<?= $this->section('content') ?>

<?php
$activeNav = 'profile';
$initials  = implode('', array_map(fn($w) => strtoupper($w[0]),
    array_slice(explode(' ', $patient['Patient_name']), 0, 2)
));
$photoUrl = (fn($f) => $f && file_exists(FCPATH . 'uploads/avatars/' . $f) ? base_url('uploads/avatars/' . $f) : '')($patient['Photo'] ?? null);
?>

<?= $this->include('components/flash') ?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">My Profile</h1>
    <p class="page-header__sub">Your account information</p>
  </div>
</div>

<div class="card" style="max-width:480px;">
  <div class="profile-card__head">
    <?php if ($photoUrl): ?>
      <img src="<?= esc($photoUrl) ?>" alt="Profile photo"
           style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto;display:block;">
    <?php else: ?>
      <div class="avatar avatar--lg avatar--green" style="margin:0 auto;"><?= $initials ?></div>
    <?php endif; ?>
    <div class="profile-card__name"><?= esc($patient['Patient_name']) ?></div>
    <div class="profile-card__code"><?= esc($patient['Patientcode']) ?></div>
  </div>

  <form action="<?= base_url('patient/profile/upload-photo') ?>" method="post" enctype="multipart/form-data"
        style="padding:0 22px 16px;">
    <?= csrf_field() ?>
    <label class="form-label">Profile Photo</label>
    <div style="display:flex;gap:10px;align-items:center;margin-top:6px;">
      <input type="file" name="photo" accept="image/jpeg,image/png,image/webp"
             class="form-control" style="flex:1;">
      <button type="submit" class="btn btn--primary" style="white-space:nowrap;">Upload</button>
    </div>
    <div style="font-size:11px;color:var(--gray-500);margin-top:4px;">JPG, PNG or WebP · max 2 MB</div>
  </form>

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
