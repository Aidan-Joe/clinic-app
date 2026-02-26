<?php

$role       = $sidebarRole   ?? 'admin';
$name       = $authName      ?? 'User';
$code       = $authCode      ?? '—';
$spec       = $authSpec      ?? '';
$available  = $authAvailable ?? true;
$notif      = $notifCount    ?? 0;
$active     = $activeNav     ?? 'dashboard';

$roleLabel  = match($role) { 'doctor' => 'Doctor Panel', 'admin' => 'Admin Panel', default => 'Patient Portal' };
$initials   = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', $name), 0, 2)));
?>

<aside class="sidebar">

  <div class="sidebar__logo">
    <div class="logo-lockup">
      <div class="logo-icon">🏥</div>
      <div class="logo-text">Clinic<em>App</em></div>
    </div>
    <div class="sidebar__role-tag"><?= esc($roleLabel) ?></div>
  </div>

  <?php if ($role === 'doctor'): ?>

  <form action="<?= base_url('doctor/update-status') ?>" method="post" id="avail-form">
    <?= csrf_field() ?>
    <div class="avail-pill" onclick="document.getElementById('avail-form').submit()" style="cursor:pointer;" title="Click to toggle availability">
      <div>
        <div class="avail-pill__label">Availability</div>
        <div class="avail-pill__status"><?= $available ? 'Available' : 'Not Available' ?></div>
      </div>
      <div class="toggle <?= $available ? '' : 'toggle--off' ?>"></div>
    </div>
  </form>
  <?php endif; ?>

  <nav class="sidebar__nav">

    <div class="nav__section">Overview</div>
    <a href="<?= base_url($role . '/dashboard') ?>" class="nav__item <?= $active === 'dashboard' ? 'is-active' : '' ?>">
      <span class="nav__icon">⊞</span> Dashboard
    </a>

    <?php if ($role === 'admin'): ?>

      <div class="nav__section">Management</div>
      <a href="<?= base_url('admin/patients') ?>" class="nav__item <?= $active === 'patients' ? 'is-active' : '' ?>">
        <span class="nav__icon">👥</span> Patients
      </a>
      <a href="<?= base_url('admin/doctors') ?>" class="nav__item <?= $active === 'doctors' ? 'is-active' : '' ?>">
        <span class="nav__icon">🩺</span> Doctors
      </a>
      <a href="<?= base_url('admin/appointments') ?>" class="nav__item <?= $active === 'appointments' ? 'is-active' : '' ?>">
        <span class="nav__icon">📅</span> Appointments
        <?php if ($notif > 0): ?>
          <span class="nav__badge"><?= $notif ?></span>
        <?php endif; ?>
      </a>
      <a href="<?= base_url('admin/rooms') ?>" class="nav__item <?= $active === 'rooms' ? 'is-active' : '' ?>">
        <span class="nav__icon">🏠</span> Rooms
      </a>
      <a href="<?= base_url('admin/records') ?>" class="nav__item <?= $active === 'records' ? 'is-active' : '' ?>">
        <span class="nav__icon">📋</span> Medical Records
      </a>

      <div class="nav__section">System</div>
      <a href="<?= base_url('admin/settings') ?>" class="nav__item <?= $active === 'settings' ? 'is-active' : '' ?>">
        <span class="nav__icon">⚙️</span> Settings
      </a>

    <?php elseif ($role === 'doctor'): ?>

      <div class="nav__section">My Work</div>
      <a href="<?= base_url('doctor/appointments') ?>" class="nav__item <?= $active === 'appointments' ? 'is-active' : '' ?>">
        <span class="nav__icon">📅</span> Appointments
        <?php if ($notif > 0): ?>
          <span class="nav__badge"><?= $notif ?></span>
        <?php endif; ?>
      </a>
      <a href="<?= base_url('doctor/patients') ?>" class="nav__item <?= $active === 'patients' ? 'is-active' : '' ?>">
        <span class="nav__icon">👥</span> My Patients
      </a>
      <a href="<?= base_url('doctor/records') ?>" class="nav__item <?= $active === 'records' ? 'is-active' : '' ?>">
        <span class="nav__icon">📋</span> Medical Records
      </a>
      <div class="nav__section">Account</div>
      <a href="<?= base_url('doctor/profile') ?>" class="nav__item <?= $active === 'profile' ? 'is-active' : '' ?>">
        <span class="nav__icon">👤</span> Profile
      </a>

    <?php endif; ?>

    <a href="<?= base_url('auth/logout') ?>" class="nav__item">
      <span class="nav__icon">🚪</span> Logout
    </a>

  </nav>

  <div class="sidebar__footer">
    <div class="profile-row">
      <?php
        $sidebarPhoto = $authPhoto ?? null;
        $sidebarPhotoUrl = (fn($f) => $f && file_exists(FCPATH . 'uploads/avatars/' . $f) ? base_url('uploads/avatars/' . $f) : '')($sidebarPhoto);
      ?>
      <?php if ($sidebarPhotoUrl): ?>
        <img src="<?= esc($sidebarPhotoUrl) ?>" alt=""
             style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;">
      <?php else: ?>
        <div class="avatar avatar--md avatar--green"><?= esc($initials) ?></div>
      <?php endif; ?>
      <div class="profile-row__info">
        <div class="profile-row__name"><?= esc($name) ?></div>
        <div class="profile-row__meta">
          <?= esc($code) ?><?= $role === 'doctor' && $spec ? ' · ' . esc($spec) : '' ?>
        </div>
      </div>
    </div>
  </div>

</aside>
