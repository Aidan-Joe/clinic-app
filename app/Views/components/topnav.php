<?php
/**
 * Top Navigation Component (Patient layout)
 *
 * Expected variables:
 *   $authName   : Patient display name
 *   $activeNav  : active nav key
 *   $notifCount : int
 */

$name   = $authName  ?? 'Patient';
$active = $activeNav ?? 'dashboard';
$notif  = $notifCount ?? 0;
$initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', $name), 0, 2)));
?>

<nav class="topnav">

  <div class="topnav__logo">
    <div class="logo-icon">🏥</div>
    <div class="logo-text">Clinic<em style="font-style:italic;color:var(--green-600)">App</em></div>
  </div>

  <div class="topnav__links">
    <a href="<?= base_url('patient/dashboard') ?>" class="topnav__link <?= $active === 'dashboard'    ? 'is-active' : '' ?>">Dashboard</a>
    <a href="<?= base_url('patient/appointments') ?>" class="topnav__link <?= $active === 'appointments' ? 'is-active' : '' ?>">Appointments</a>
    <a href="<?= base_url('patient/records') ?>" class="topnav__link <?= $active === 'records'       ? 'is-active' : '' ?>">Medical Records</a>
    <a href="<?= base_url('patient/profile') ?>" class="topnav__link <?= $active === 'profile'       ? 'is-active' : '' ?>">Profile</a>
  </div>

  <div class="topnav__right">
    <div class="icon-btn">
      🔔
      <?php if ($notif > 0): ?>
        <div class="icon-btn__dot"></div>
      <?php endif; ?>
    </div>
    <div class="user-chip">
      <div class="avatar avatar--sm avatar--green"><?= esc($initials) ?></div>
      <span class="user-chip__name"><?= esc($name) ?></span>
    </div>
  </div>

</nav>
