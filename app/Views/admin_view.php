<?php
/**
 * Admin Dashboard View
 * Layout  : layouts/main
 * Sidebar : components/sidebar (role = admin)
 *
 * Controller should pass:
 *   $authName, $authCode, $notifCount
 *   $stats       : ['patients', 'doctors', 'appointments_today', 'rooms_available']
 *   $appointments : array of today's appointment rows
 *   $doctors      : array of doctor rows
 *   $rooms        : array of room rows
 */
$this->extend('layouts/main');
$this->section('content');

// Sidebar identity — picked up by the sidebar component
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

  <div class="stat-card anim-d1">
    <div class="stat-card__icon">👥</div>
    <div class="stat-card__value"><?= esc($stats['patients'] ?? 248) ?></div>
    <div class="stat-card__label">Total Patients</div>
    <span class="stat-card__delta delta--up">+12 this week</span>
  </div>

  <div class="stat-card anim-d2">
    <div class="stat-card__icon">🩺</div>
    <div class="stat-card__value"><?= esc($stats['doctors'] ?? 18) ?></div>
    <div class="stat-card__label">Active Doctors</div>
    <span class="stat-card__delta delta--up">+2 new</span>
  </div>

  <div class="stat-card anim-d3">
    <div class="stat-card__icon">📅</div>
    <div class="stat-card__value"><?= esc($stats['appointments_today'] ?? 34) ?></div>
    <div class="stat-card__label">Today's Appointments</div>
    <span class="stat-card__delta delta--up">+8 vs. yesterday</span>
  </div>

  <div class="stat-card stat-card--warn anim-d4">
    <div class="stat-card__icon">🏠</div>
    <div class="stat-card__value"><?= esc($stats['rooms_available'] ?? 6) ?></div>
    <div class="stat-card__label">Rooms Available</div>
    <span class="stat-card__delta delta--down">2 occupied</span>
  </div>

</div>

<!-- APPOINTMENTS + DOCTORS -->
<div class="grid-cols-2 anim-d5">

  <!-- Today's Appointments Table -->
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
          <?php
          $appointments = $appointments ?? [
            ['patient_name'=>'Rina Ayu',      'patient_code'=>'PT001','doctor_name'=>'Dr. Hendra','spec'=>'Cardiology',  'room'=>'R-01','time'=>'08:30','symptoms'=>'Chest pain, shortness of breath','status'=>'completed'],
            ['patient_name'=>'Budi Santoso',   'patient_code'=>'PT002','doctor_name'=>'Dr. Sari',  'spec'=>'General',     'room'=>'R-03','time'=>'09:00','symptoms'=>'Fever, headache',               'status'=>'scheduled'],
            ['patient_name'=>'Maya Putri',     'patient_code'=>'PT003','doctor_name'=>'Dr. Wahyu', 'spec'=>'Dermatology', 'room'=>'R-05','time'=>'10:15','symptoms'=>'Skin rash, itching',            'status'=>'scheduled'],
            ['patient_name'=>'Dian Novita',    'patient_code'=>'PT004','doctor_name'=>'Dr. Hendra','spec'=>'Cardiology',  'room'=>'R-01','time'=>'11:00','symptoms'=>'Palpitations',                  'status'=>'cancelled'],
            ['patient_name'=>'Agus Prasetyo',  'patient_code'=>'PT005','doctor_name'=>'Dr. Sari',  'spec'=>'General',     'room'=>'R-02','time'=>'13:30','symptoms'=>'Cold, runny nose',              'status'=>'scheduled'],
          ];
          foreach ($appointments as $appt): ?>
          <tr>
            <td>
              <div class="td--name"><?= esc($appt['patient_name']) ?></div>
              <div class="td--muted"><?= esc($appt['patient_code']) ?></div>
            </td>
            <td>
              <div><?= esc($appt['doctor_name']) ?></div>
              <div class="td--muted"><?= esc($appt['spec']) ?></div>
            </td>
            <td><?= esc($appt['room']) ?></td>
            <td><?= esc($appt['time']) ?></td>
            <td style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" class="td--muted">
              <?= esc($appt['symptoms']) ?>
            </td>
            <td>
              <span class="badge badge--<?= esc($appt['status']) ?>">
                <?= ucfirst(esc($appt['status'])) ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Doctors On Duty -->
  <div class="card">
    <div class="card__header">
      <span class="card__title">Doctors On Duty</span>
      <a href="<?= base_url('admin/doctors') ?>" class="card__action">Manage →</a>
    </div>
    <div class="doctor-list">
      <?php
      $avatarClasses = ['avatar--green','avatar--teal','avatar--olive','avatar--sage','avatar--moss','avatar--fern'];
      $doctors = $doctors ?? [
        ['name'=>'Dr. Hendra Wijaya',   'code'=>'DC001','spec'=>'Cardiology',       'availability'=>'Available'],
        ['name'=>'Dr. Sari Rahayu',     'code'=>'DC002','spec'=>'General Practice', 'availability'=>'Available'],
        ['name'=>'Dr. Wahyu Nugroho',   'code'=>'DC003','spec'=>'Dermatology',      'availability'=>'Not Available'],
        ['name'=>'Dr. Andi Permana',    'code'=>'DC004','spec'=>'Neurology',        'availability'=>'Available'],
        ['name'=>'Dr. Fitri Handayani', 'code'=>'DC005','spec'=>'Pediatrics',       'availability'=>'Available'],
      ];
      foreach ($doctors as $i => $doc):
        $initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', preg_replace('/^Dr\.\s*/', '', $doc['name'])), 0, 2)));
        $avClass  = $avatarClasses[$i % count($avatarClasses)];
        $isAvail  = $doc['availability'] === 'Available';
      ?>
      <div class="doctor-list__item">
        <div class="avatar avatar--md <?= $avClass ?>"><?= $initials ?></div>
        <div class="doctor-list__info">
          <div class="doctor-list__name"><?= esc($doc['name']) ?></div>
          <div class="doctor-list__spec"><?= esc($doc['spec']) ?> · <?= esc($doc['code']) ?></div>
        </div>
        <span class="badge <?= $isAvail ? 'badge--available' : 'badge--occupied' ?>">
          <?= esc($doc['availability']) ?>
        </span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<!-- ROOMS -->
<div class="section-bar anim-d6">
  <span class="section-bar__title">Room Status</span>
  <a href="<?= base_url('admin/rooms') ?>" class="card__action">View all →</a>
</div>

<div class="grid-cols-3">
  <?php
  $rooms = $rooms ?? [
    ['Room_Code'=>'R-01','Room_Name'=>'Cardiology Ward A',     'Room_Type'=>'Examination Room', 'Status'=>'Occupied'],
    ['Room_Code'=>'R-02','Room_Name'=>'General Consultation B', 'Room_Type'=>'Consultation Room','Status'=>'Available'],
    ['Room_Code'=>'R-03','Room_Name'=>'Dermatology Suite',      'Room_Type'=>'Treatment Room',   'Status'=>'Available'],
    ['Room_Code'=>'R-04','Room_Name'=>'Neurology Lab',          'Room_Type'=>'Examination Room', 'Status'=>'Occupied'],
    ['Room_Code'=>'R-05','Room_Name'=>'Pediatrics Ward',        'Room_Type'=>'Ward',             'Status'=>'Available'],
    ['Room_Code'=>'R-06','Room_Name'=>'Emergency Suite',        'Room_Type'=>'ICU',              'Status'=>'Available'],
  ];
  foreach ($rooms as $room):
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
</div>

<?php $this->endSection(); ?>
