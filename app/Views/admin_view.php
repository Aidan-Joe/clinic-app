<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'dashboard';
?>

<!-- PAGE HEADER -->
<div class="page-header">
  <div>
    <h1 class="page-header__title">Dashboard Overview</h1>
    <p class="page-header__sub"><?= date('l, j F Y') ?> — Good morning 👋</p>
  </div>
  <div class="page-header__actions">
    <button class="btn btn--ghost">📤 Export Report</button>
    <button class="btn btn--primary">＋ New Appointment</button>
  </div>
</div>

<!-- STAT CARDS -->
<div class="stats-grid stats-grid--4">

  <div class="stat-card">
    <div class="stat-card__icon">👥</div>
    <div class="stat-card__value"><?= esc($stats['patients']) ?></div>
    <div class="stat-card__label">Total Patients</div>
  </div>

  <div class="stat-card">
    <div class="stat-card__icon">🩺</div>
    <div class="stat-card__value"><?= esc($stats['doctors']) ?></div>
    <div class="stat-card__label">Active Doctors</div>
  </div>

  <div class="stat-card">
    <div class="stat-card__icon">📅</div>
    <div class="stat-card__value"><?= esc($stats['appointments_today']) ?></div>
    <div class="stat-card__label">Today's Appointments</div>
  </div>

  <div class="stat-card stat-card--warn">
    <div class="stat-card__icon">🏠</div>
    <div class="stat-card__value"><?= esc($stats['rooms_available']) ?></div>
    <div class="stat-card__label">Rooms Available</div>
  </div>

</div>

<!-- APPOINTMENTS + DOCTORS -->
<div class="grid-cols-2">

  <!-- APPOINTMENTS -->
  <div class="card">
    <div class="card__header">
      <span class="card__title">Today's Appointments</span>
      <a href="<?= base_url('admin/appointments') ?>" class="card__action">View all →</a>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Room</th>
            <th>Time</th>
            <th>Symptoms</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>

        <?php if (!empty($appointments)): ?>
            <?php foreach ($appointments as $appt): ?>
            <tr>
              <td>
                <div class="td--name"><?= esc($appt['patient_name']) ?></div>
                <div class="td--muted"><?= esc($appt['patient_code']) ?></div>
              </td>
              <td>
                <div><?= esc($appt['doctor_name']) ?></div>
                <div class="td--muted"><?= esc($appt['spec']) ?></div>
              </td>
              <td><?= esc($appt['room'] ?? '-') ?></td>
              <td><?= esc($appt['time']) ?></td>
              <td class="td--muted" style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                <?= esc($appt['symptoms']) ?>
              </td>
              <td>
                <span class="badge badge--<?= esc($appt['status']) ?>">
                  <?= ucfirst((string) $appt['status']) ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;">No appointments today</td>
            </tr>
        <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>

  <!-- DOCTORS -->
  <div class="card">
    <div class="card__header">
      <span class="card__title">Doctors On Duty</span>
      <a href="<?= base_url('admin/doctors') ?>" class="card__action">Manage →</a>
    </div>

    <div class="doctor-list">
      <?php if (!empty($doctors)): ?>
        <?php 
        $avatarClasses = ['avatar--green','avatar--teal','avatar--olive','avatar--sage','avatar--moss','avatar--fern'];
        foreach ($doctors as $i => $doc): 
            $initials = implode('', array_map(fn($w) => strtoupper($w[0]), 
                array_slice(explode(' ', preg_replace('/^Dr\.\s*/', '', $doc['Doctor_name'])), 0, 2)
            ));
            $avClass = $avatarClasses[$i % count($avatarClasses)];
            $isAvail = $doc['Availability'] === 'Available';
        ?>
        <div class="doctor-list__item">
          <div class="avatar avatar--md <?= $avClass ?>"><?= $initials ?></div>
          <div class="doctor-list__info">
            <div class="doctor-list__name"><?= esc($doc['Doctor_name']) ?></div>
            <div class="doctor-list__spec">
              <?= esc($doc['Specialization']) ?> · <?= esc($doc['DoctorCode']) ?>
            </div>
          </div>
          <span class="badge <?= $isAvail ? 'badge--available' : 'badge--occupied' ?>">
            <?= esc($doc['Availability']) ?>
          </span>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="padding:16px;">No doctors found</p>
      <?php endif; ?>
    </div>
  </div>

</div>

<!-- ROOMS -->
<div class="section-bar">
  <span class="section-bar__title">Room Status</span>
  <a href="<?= base_url('admin/rooms') ?>" class="card__action">View all →</a>
</div>

<div class="grid-cols-3">

<?php if (!empty($rooms)): ?>
  <?php foreach ($rooms as $room): 
      $isOcc = $room['Status'] === 'Occupied';
  ?>
  <div class="room-card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
      <div>
        <div class="room-card__code"><?= esc($room['Room_Code']) ?></div>
        <div class="room-card__name"><?= esc($room['Room_Name']) ?></div>
        <div class="room-card__type"><?= esc($room['Room_Type']) ?></div>
      </div>
      <span class="badge <?= $isOcc ? 'badge--occupied' : 'badge--available' ?>">
        <?= esc($room['Status']) ?>
      </span>
    </div>
  </div>
  <?php endforeach; ?>
<?php else: ?>
  <p style="padding:16px;">No rooms available</p>
<?php endif; ?>

</div>

<?= $this->endSection() ?>