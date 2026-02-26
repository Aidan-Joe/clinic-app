<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'doctor';
$initials    = implode('', array_map(fn($w) => strtoupper($w[0]),
    array_slice(explode(' ', preg_replace('/^Dr\.\s*/', '', $doctor['Doctor_name'])), 0, 2)
));
$photoUrl = (fn($f) => $f && file_exists(FCPATH . 'uploads/avatars/' . $f) ? base_url('uploads/avatars/' . $f) : '')($doctor['Photo'] ?? null);
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
    <div class="profile-card__name"><?= esc($doctor['Doctor_name']) ?></div>
    <div class="profile-card__code"><?= esc($doctor['DoctorCode']) ?> · <?= esc($doctor['Specialization']) ?></div>
  </div>

  <form action="<?= base_url('doctor/profile/upload-photo') ?>" method="post" enctype="multipart/form-data"
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
      <span><?= esc($doctor['Doctor_email']) ?></span>
    </div>
    <div class="detail-row">
      <span>Phone</span>
      <span><?= esc($doctor['Phone']) ?></span>
    </div>
    <div class="detail-row">
      <span>Specialization</span>
      <span><?= esc($doctor['Specialization']) ?></span>
    </div>
    <div class="detail-row">
      <span>Availability</span>
      <span>
        <span class="badge <?= $doctor['Availability'] === 'Available' ? 'badge--available' : 'badge--occupied' ?>">
          <?= esc($doctor['Availability']) ?>
        </span>
      </span>
    </div>
  </div>
  <div style="padding:16px 22px;">
    <form action="<?= base_url('doctor/update-status') ?>" method="post">
      <?= csrf_field() ?>
      <button type="submit" class="btn btn--ghost" style="width:100%;">
        Toggle Availability
      </button>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
