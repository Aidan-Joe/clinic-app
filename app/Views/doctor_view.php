<?php
/**
 * Doctor Dashboard View
 * Layout  : layouts/main
 * Sidebar : components/sidebar (role = doctor)
 *
 * Controller should pass:
 *   $authName, $authCode, $authSpec, $authAvailable, $notifCount
 *   $stats         : ['appointments_today', 'completed', 'total_patients', 'records_pending']
 *   $queue         : array of today's appointment rows for this doctor
 *   $recentRecords : array of recent medical records written by this doctor
 *   $nextPatient   : associative array for the next-up patient card
 *   $myRoom        : ['Room_Code', 'Room_Name', 'Room_Type', 'Status']
 */
$this->extend('layouts/main');
$this->section('content');

$sidebarRole = 'doctor';
$activeNav   = 'dashboard';
?>

<!-- PAGE HEADER -->
<div class="page-header">
  <div>
    <h1 class="page-header__title">My Schedule</h1>
    <p class="page-header__sub"><?= date('l, j F Y') ?></p>
  </div>
  <div class="page-header__actions">
    <button class="btn btn--ghost">🗓 Schedule View</button>
    <button class="btn btn--primary">📝 Write Diagnosis</button>
  </div>
</div>

<!-- STAT CARDS -->
<div class="stats-grid stats-grid--4">

  <div class="stat-card anim-d1">
    <div class="stat-card__icon">📅</div>
    <div class="stat-card__value"><?= esc($stats['appointments_today'] ?? 7) ?></div>
    <div class="stat-card__label">Today's Appointments</div>
    <span class="stat-card__delta delta--up">↑ 3 new</span>
  </div>

  <div class="stat-card anim-d2">
    <div class="stat-card__icon">✅</div>
    <div class="stat-card__value"><?= esc($stats['completed'] ?? 2) ?></div>
    <div class="stat-card__label">Completed Today</div>
    <span class="stat-card__delta delta--up">Done</span>
  </div>

  <div class="stat-card anim-d3">
    <div class="stat-card__icon">👥</div>
    <div class="stat-card__value"><?= esc($stats['total_patients'] ?? 41) ?></div>
    <div class="stat-card__label">Total My Patients</div>
    <span class="stat-card__delta delta--up">↑ 5</span>
  </div>

  <div class="stat-card stat-card--warn anim-d4">
    <div class="stat-card__icon">📋</div>
    <div class="stat-card__value"><?= esc($stats['records_pending'] ?? 3) ?></div>
    <div class="stat-card__label">Records Pending</div>
    <span class="stat-card__delta delta--warn">Needs review</span>
  </div>

</div>

<!-- MAIN GRID -->
<div class="grid-cols-2 anim-d5">

  <!-- LEFT: Queue + Records -->
  <div style="display:flex;flex-direction:column;gap:18px;">

    <!-- Patient Queue -->
    <div class="card">
      <div class="card__header">
        <span class="card__title">Today's Patient Queue</span>
        <a href="<?= base_url('doctor/appointments') ?>" class="card__action">Full schedule →</a>
      </div>
      <div class="timeline">
        <?php
        $queue = $queue ?? [
          ['time'=>'08:30','period'=>'AM','patient_name'=>'Rina Ayu Lestari', 'symptoms'=>'Chest pain, shortness of breath','room'=>'R-01','appt_code'=>'AP001','status'=>'completed'],
          ['time'=>'09:30','period'=>'AM','patient_name'=>'Dian Novita Sari',  'symptoms'=>'Heart palpitations, dizziness',  'room'=>'R-01','appt_code'=>'AP004','status'=>'next'],
          ['time'=>'11:00','period'=>'AM','patient_name'=>'Bambang Sutrisno',  'symptoms'=>'Blood pressure check, follow-up','room'=>'R-01','appt_code'=>'AP007','status'=>'scheduled'],
          ['time'=>'13:00','period'=>'PM','patient_name'=>'Kartika Dewi',      'symptoms'=>'Irregular heartbeat',            'room'=>'R-01','appt_code'=>'AP009','status'=>'scheduled'],
          ['time'=>'14:30','period'=>'PM','patient_name'=>'Farhan Maulana',    'symptoms'=>'Post-surgery follow-up',         'room'=>'R-01','appt_code'=>'AP012','status'=>'cancelled'],
        ];
        foreach ($queue as $row):
          $badgeMap = ['completed'=>'badge--completed','scheduled'=>'badge--scheduled','cancelled'=>'badge--cancelled','next'=>'badge--next'];
          $badgeClass = $badgeMap[$row['status']] ?? 'badge--scheduled';
          $badgeLabel = $row['status'] === 'next' ? '→ Next' : ucfirst($row['status']);
          $isHighlight = $row['status'] === 'next';
        ?>
        <div class="timeline__item" <?= $isHighlight ? 'style="background:var(--accent-xlight)"' : '' ?>>
          <div class="timeline__side">
            <div class="timeline__date"><?= esc($row['time']) ?></div>
            <div class="timeline__month"><?= esc($row['period']) ?></div>
            <div class="timeline__line"></div>
          </div>
          <div class="timeline__body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
              <div>
                <div class="timeline__doctor"><?= esc($row['patient_name']) ?></div>
                <div class="timeline__spec" style="color:var(--gray-400)"><?= esc($row['symptoms']) ?></div>
              </div>
              <span class="badge <?= $badgeClass ?>"><?= $badgeLabel ?></span>
            </div>
            <div class="timeline__meta">
              <span class="chip">🏠 <?= esc($row['room']) ?></span>
              <span class="chip"><?= esc($row['appt_code']) ?></span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Recent Medical Records -->
    <div class="card">
      <div class="card__header">
        <span class="card__title">Recent Medical Records</span>
        <a href="<?= base_url('doctor/records') ?>" class="card__action">All records →</a>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Code</th>
              <th>Patient</th>
              <th>Visit Date</th>
              <th>Diagnosis</th>
              <th>Prescription</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $recentRecords = $recentRecords ?? [
              ['RecordCode'=>'RC001','patient_name'=>'Rina Ayu',    'patient_code'=>'PT001','Visit_date'=>'12 Feb 2026','Diagnosis'=>'Angina Pectoris',     'Prescription'=>'Nitroglycerin 0.5mg, Aspirin 100mg'],
              ['RecordCode'=>'RC002','patient_name'=>'Bambang S.', 'patient_code'=>'PT008','Visit_date'=>'10 Feb 2026','Diagnosis'=>'Hypertension Stage 2', 'Prescription'=>'Amlodipine 5mg, Lisinopril 10mg'],
              ['RecordCode'=>'RC003','patient_name'=>'Dian Novita','patient_code'=>'PT004','Visit_date'=>'08 Feb 2026','Diagnosis'=>'Atrial Fibrillation',  'Prescription'=>'Warfarin 5mg, Metoprolol 50mg'],
            ];
            foreach ($recentRecords as $rec): ?>
            <tr>
              <td class="td--muted"><?= esc($rec['RecordCode']) ?></td>
              <td>
                <div class="td--name"><?= esc($rec['patient_name']) ?></div>
                <div class="td--muted"><?= esc($rec['patient_code']) ?></div>
              </td>
              <td class="td--muted"><?= esc($rec['Visit_date']) ?></td>
              <td><?= esc($rec['Diagnosis']) ?></td>
              <td class="td--muted" style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                <?= esc($rec['Prescription']) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- RIGHT: Next Patient + Room -->
  <div style="display:flex;flex-direction:column;gap:18px;">

    <!-- Next Patient Card -->
    <?php
    $next = $nextPatient ?? [
      'patient_name' => 'Dian Novita Sari',
      'patient_code' => 'PT004',
      'appt_code'    => 'AP004',
      'gender'       => 'Female',
      'birthdate'    => '14 Mar 1990',
      'phone'        => '0812-3456-7890',
      'room'         => 'R-01',
      'symptoms'     => 'Heart palpitations and intermittent dizziness over the last 3 days.',
    ];
    $nextInitials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', $next['patient_name']), 0, 2)));
    ?>
    <div class="card">
      <div class="card__header">
        <span class="card__title">Next Patient</span>
        <span class="badge badge--next" style="font-size:11px;">In Queue</span>
      </div>
      <div class="card__body">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:4px;">
          <div class="avatar avatar--lg avatar--teal"><?= $nextInitials ?></div>
          <div>
            <div style="font-size:15px;font-weight:600;color:var(--gray-900);"><?= esc($next['patient_name']) ?></div>
            <div style="font-size:11px;color:var(--gray-500);"><?= esc($next['patient_code']) ?> · <?= esc($next['appt_code']) ?></div>
          </div>
        </div>

        <div class="info-grid">
          <div class="info-grid__item">
            <div class="info-grid__label">Gender</div>
            <div class="info-grid__val"><?= esc($next['gender']) ?></div>
          </div>
          <div class="info-grid__item">
            <div class="info-grid__label">Date of Birth</div>
            <div class="info-grid__val"><?= esc($next['birthdate']) ?></div>
          </div>
          <div class="info-grid__item">
            <div class="info-grid__label">Phone</div>
            <div class="info-grid__val"><?= esc($next['phone']) ?></div>
          </div>
          <div class="info-grid__item">
            <div class="info-grid__label">Room</div>
            <div class="info-grid__val"><?= esc($next['room']) ?></div>
          </div>
        </div>

        <div class="next-patient__symptom-box">
          <div class="next-patient__symptom-label">⚠ Reported Symptoms</div>
          <div class="next-patient__symptom-text"><?= esc($next['symptoms']) ?></div>
        </div>

        <button class="btn btn--primary" style="width:100%;margin-top:14px;justify-content:center;">
          📝 Write Diagnosis &amp; Prescription
        </button>
      </div>
    </div>

    <!-- My Room -->
    <?php
    $myRoom = $myRoom ?? ['Room_Code'=>'R-01','Room_Name'=>'Cardiology Ward A','Room_Type'=>'Examination Room','Status'=>'Occupied'];
    $isOcc  = $myRoom['Status'] === 'Occupied';
    ?>
    <div class="card">
      <div class="card__header">
        <span class="card__title">My Room</span>
      </div>
      <div class="card__body">
        <div class="room-mini">
          <div class="room-mini__icon">🏠</div>
          <div>
            <div class="room-mini__code"><?= esc($myRoom['Room_Code']) ?></div>
            <div class="room-mini__name"><?= esc($myRoom['Room_Name']) ?> · <?= esc($myRoom['Room_Type']) ?></div>
          </div>
        </div>
        <div class="room-status-row">
          <span class="room-status-row__label">Room Status</span>
          <span class="badge <?= $isOcc ? 'badge--occupied' : 'badge--available' ?>">
            <?= esc($myRoom['Status']) ?>
          </span>
        </div>
      </div>
    </div>

  </div>
</div>

<?php $this->endSection(); ?>
