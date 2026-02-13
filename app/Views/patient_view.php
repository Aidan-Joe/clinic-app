<?php
/**
 * Patient Dashboard View
 * Layout  : layouts/topnav
 * Nav     : components/topnav
 *
 * Controller should pass:
 *   $authName, $authCode, $notifCount
 *   $patient       : full patient row ['Patient_name','Patientcode','Gender','Birthdate','Phone','Patient_email','Address']
 *   $stats         : ['upcoming', 'records', 'prescriptions']
 *   $appointments  : array of appointment rows (most recent first)
 *   $records       : array of medical record rows
 *   $doctors       : array of available doctors for the booking form
 */
$this->extend('layouts/topnav');
$this->section('content');

$activeNav = 'dashboard';

$patient = $patient ?? [
  'Patient_name'  => 'Rina Ayu Lestari',
  'Patientcode'   => 'PT001',
  'Gender'        => 'Female',
  'Birthdate'     => '1990-03-14',
  'Phone'         => '0812-3456-7890',
  'Patient_email' => 'rina.ayu@email.com',
  'Address'       => 'Jl. Mawar No. 12, Jakarta',
];

$displayBirthdate = date('j M Y', strtotime($patient['Birthdate']));
$initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', $patient['Patient_name']), 0, 2)));
?>

<!-- HERO BANNER -->
<div class="hero-banner">
  <div class="hero-banner__greeting">Good morning ☀️</div>
  <div class="hero-banner__name"><?= esc($patient['Patient_name']) ?></div>
  <div class="hero-banner__sub">
    Patient ID: <?= esc($patient['Patientcode']) ?> &nbsp;·&nbsp; Member since January 2026
  </div>
  <div class="hero-banner__pills">
    <div class="hero-pill">📅 <span>Next: 13 Feb @ 09:30</span></div>
    <div class="hero-pill">👨‍⚕️ <span>Dr. Hendra Wijaya</span></div>
    <div class="hero-pill">🏠 <span>Room R-01</span></div>
  </div>
  <div class="hero-banner__cta">
    <button class="btn btn--white">＋ Book Appointment</button>
  </div>
</div>

<!-- STAT CARDS -->
<?php $stats = $stats ?? ['upcoming' => 3, 'records' => 5, 'prescriptions' => 2]; ?>
<div class="stats-grid stats-grid--3">

  <div class="stat-card anim-d1">
    <div class="stat-card__icon">📅</div>
    <div class="stat-card__value"><?= esc($stats['upcoming']) ?></div>
    <div class="stat-card__label">Upcoming Appointments</div>
    <span class="stat-card__delta delta--up">↑ 1 added</span>
  </div>

  <div class="stat-card anim-d2">
    <div class="stat-card__icon">📋</div>
    <div class="stat-card__value"><?= esc($stats['records']) ?></div>
    <div class="stat-card__label">Medical Records</div>
    <span class="stat-card__delta delta--up">5 total</span>
  </div>

  <div class="stat-card anim-d3">
    <div class="stat-card__icon">💊</div>
    <div class="stat-card__value"><?= esc($stats['prescriptions']) ?></div>
    <div class="stat-card__label">Active Prescriptions</div>
    <span class="stat-card__delta delta--up">Active</span>
  </div>

</div>

<!-- MAIN TWO COLUMNS -->
<div class="grid-cols-2 anim-d4">

  <!-- LEFT: Appointments + Records -->
  <div style="display:flex;flex-direction:column;gap:18px;">

    <!-- Appointment Timeline -->
    <div class="card">
      <div class="card__header">
        <span class="card__title">My Appointments</span>
        <a href="<?= base_url('patient/appointments') ?>" class="card__action">View all →</a>
      </div>
      <div class="timeline">
        <?php
        $appointments = $appointments ?? [
          ['day'=>'13','month'=>'Feb','doctor'=>'Dr. Hendra Wijaya','spec'=>'Cardiology · DC001','time'=>'09:30 AM','room'=>'R-01','appt_code'=>'AP004','symptoms'=>'Heart palpitations and intermittent dizziness','status'=>'next'],
          ['day'=>'20','month'=>'Feb','doctor'=>'Dr. Hendra Wijaya','spec'=>'Cardiology · DC001','time'=>'11:00 AM','room'=>'R-01','appt_code'=>'AP011','symptoms'=>'','status'=>'scheduled'],
          ['day'=>'12','month'=>'Feb','doctor'=>'Dr. Hendra Wijaya','spec'=>'Cardiology · DC001','time'=>'08:30 AM','room'=>'R-01','appt_code'=>'AP001','symptoms'=>'','status'=>'completed'],
        ];
        $badgeMap = ['next'=>'badge--next','scheduled'=>'badge--scheduled','completed'=>'badge--completed','cancelled'=>'badge--cancelled'];
        $badgeLbl = ['next'=>'Today','scheduled'=>'Scheduled','completed'=>'Completed','cancelled'=>'Cancelled'];

        foreach ($appointments as $appt):
          $bClass = $badgeMap[$appt['status']] ?? 'badge--scheduled';
          $bLabel = $badgeLbl[$appt['status']] ?? ucfirst($appt['status']);
        ?>
        <div class="timeline__item">
          <div class="timeline__side">
            <div class="timeline__date"><?= esc($appt['day']) ?></div>
            <div class="timeline__month"><?= esc($appt['month']) ?></div>
            <div class="timeline__line"></div>
          </div>
          <div class="timeline__body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
              <div>
                <div class="timeline__doctor"><?= esc($appt['doctor']) ?></div>
                <div class="timeline__spec"><?= esc($appt['spec']) ?></div>
              </div>
              <span class="badge <?= $bClass ?>"><?= $bLabel ?></span>
            </div>
            <div class="timeline__meta">
              <span class="chip">🕐 <?= esc($appt['time']) ?></span>
              <span class="chip">🏠 <?= esc($appt['room']) ?></span>
              <span class="chip"><?= esc($appt['appt_code']) ?></span>
            </div>
            <?php if (!empty($appt['symptoms'])): ?>
            <div class="timeline__symptom">
              <?= esc($appt['symptoms']) ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Medical Records -->
    <div class="card">
      <div class="card__header">
        <span class="card__title">My Medical Records</span>
        <a href="<?= base_url('patient/records') ?>" class="card__action">View all →</a>
      </div>
      <?php
      $records = $records ?? [
        ['RecordCode'=>'RC001','Visit_date'=>'12 Feb 2026','Diagnosis'=>'Angina Pectoris',    'Treatment'=>'Rest, avoid strenuous activity','Prescription'=>'Nitroglycerin 0.5mg, Aspirin 100mg daily'],
        ['RecordCode'=>'RC005','Visit_date'=>'28 Jan 2026','Diagnosis'=>'Hypertension Grade 1','Treatment'=>'Low sodium diet, regular monitoring','Prescription'=>'Amlodipine 5mg once daily'],
      ];
      foreach ($records as $rec): ?>
      <div class="rec-card">
        <div class="rec-card__top">
          <span class="rec-card__code"><?= esc($rec['RecordCode']) ?></span>
          <span class="rec-card__date"><?= esc($rec['Visit_date']) ?></span>
        </div>
        <div class="rec-card__diagnosis"><?= esc($rec['Diagnosis']) ?></div>
        <div class="rec-card__detail">💊 <?= esc($rec['Prescription']) ?></div>
        <div class="rec-card__detail">🩺 <?= esc($rec['Treatment']) ?></div>
        <div class="rec-card__link">View full record →</div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>

  <!-- RIGHT: Profile + Book Appointment -->
  <div style="display:flex;flex-direction:column;gap:18px;">

    <!-- Profile Card -->
    <div class="card">
      <div class="profile-card__head">
        <div class="avatar avatar--lg avatar--green" style="margin:0 auto;"><?= $initials ?></div>
        <div class="profile-card__name"><?= esc($patient['Patient_name']) ?></div>
        <div class="profile-card__code">Patient Code: <?= esc($patient['Patientcode']) ?></div>
      </div>
      <div class="detail-list">
        <div class="detail-row">
          <span class="detail-row__key">Gender</span>
          <span class="detail-row__val"><?= esc($patient['Gender']) ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-row__key">Date of Birth</span>
          <span class="detail-row__val"><?= esc($displayBirthdate) ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-row__key">Phone</span>
          <span class="detail-row__val"><?= esc($patient['Phone']) ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-row__key">Email</span>
          <span class="detail-row__val"><?= esc($patient['Patient_email']) ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-row__key">Address</span>
          <span class="detail-row__val"><?= esc($patient['Address']) ?></span>
        </div>
      </div>
    </div>

    <!-- Book Appointment Form -->
    <div class="card">
      <div class="card__header">
        <span class="card__title">📅 Book New Appointment</span>
      </div>
      <div class="card__body">
        <?php
        $doctors = $doctors ?? [
          ['DoctorCode'=>'DC001','Doctor_name'=>'Dr. Hendra Wijaya','Specialization'=>'Cardiology'],
          ['DoctorCode'=>'DC002','Doctor_name'=>'Dr. Sari Rahayu',  'Specialization'=>'General Practice'],
          ['DoctorCode'=>'DC003','Doctor_name'=>'Dr. Wahyu Nugroho','Specialization'=>'Dermatology'],
          ['DoctorCode'=>'DC004','Doctor_name'=>'Dr. Andi Permana', 'Specialization'=>'Neurology'],
        ];
        ?>
        <form action="<?= base_url('patient/appointments/store') ?>" method="post">
          <?= csrf_field() ?>

          <div class="form-group">
            <label class="form-label" for="doctor">Doctor</label>
            <select class="form-control" name="DoctorCode" id="doctor" required>
              <option value="">— Select a doctor —</option>
              <?php foreach ($doctors as $doc): ?>
              <option value="<?= esc($doc['DoctorCode']) ?>">
                <?= esc($doc['Doctor_name']) ?> — <?= esc($doc['Specialization']) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="appt_date">Preferred Date</label>
            <input type="date" class="form-control" name="Appointment_date" id="appt_date"
                   min="<?= date('Y-m-d') ?>" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="appt_time">Preferred Time</label>
            <input type="time" class="form-control" name="Appointment_time" id="appt_time" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="symptoms">Symptoms / Notes</label>
            <textarea class="form-control" name="Symptoms" id="symptoms"
                      placeholder="Describe your symptoms..."></textarea>
          </div>

          <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">
            Request Appointment
          </button>

        </form>
      </div>
    </div>

  </div>
</div>

<?php $this->endSection(); ?>
