<?php
$this->extend('layouts/topnav');
$this->section('content');

$activeNav = 'dashboard';
?>

<?php if (!empty($patient)):
  $displayBirthdate = date('j M Y', strtotime($patient['Birthdate']));
  $initials = implode('', array_map(
    fn($w) => strtoupper($w[0]),
    array_slice(explode(' ', $patient['Patient_name']), 0, 2)
  ));
?>

  <div class="hero-banner">
    <div class="hero-banner__greeting">Welcome 👋</div>
    <div class="hero-banner__name"><?= esc((string) $patient['Patient_name']) ?></div>
    <div class="hero-banner__sub">
      Patient ID: <?= esc((string) $patient['Patientcode']) ?>
    </div>
  </div>

<?php endif; ?>

<div class="stats-grid stats-grid--3">

  <div class="stat-card">
    <div class="stat-card__icon">📅</div>
    <div class="stat-card__value"><?= esc((string) $stats['upcoming']) ?></div>
    <div class="stat-card__label">Upcoming Appointments</div>
  </div>

  <div class="stat-card">
    <div class="stat-card__icon">📋</div>
    <div class="stat-card__value"><?= esc((string) $stats['records']) ?></div>
    <div class="stat-card__label">Medical Records</div>
  </div>

  <div class="stat-card">
    <div class="stat-card__icon">💊</div>
    <div class="stat-card__value"><?= esc((string) $stats['prescriptions']) ?></div>
    <div class="stat-card__label">Active Prescriptions</div>
  </div>

</div>

<div class="grid-cols-2">

  <div style="display:flex;flex-direction:column;gap:18px;">

    <div class="card">
      <div class="card__header">
        <span class="card__title">My Appointments</span>
      </div>

      <div class="timeline">
        <?php if (!empty($appointments)): ?>
          <?php foreach ($appointments as $appt):
            $status = (string) ($appt['Status'] ?? '');
            $badgeMap = [
              'scheduled' => 'badge--scheduled',
              'completed' => 'badge--completed',
              'cancelled' => 'badge--cancelled'
            ];
            $badgeClass = $badgeMap[$status] ?? 'badge--scheduled';
          ?>
            <div class="timeline__item">
              <div class="timeline__side">
                <div class="timeline__date">
                  <?= date('d', strtotime($appt['Appointment_date'])) ?>
                </div>
                <div class="timeline__month">
                  <?= date('M', strtotime($appt['Appointment_date'])) ?>
                </div>
              </div>

              <div class="timeline__body">
                <div style="display:flex;justify-content:space-between;">
                  <div>
                    <div class="timeline__doctor">
                      <?= esc((string) ($appt['Doctor_name'] ?? $appt['DoctorCode'])) ?>
                    </div>
                    <div class="timeline__spec">
                      <?= esc((string) ($appt['Specialization'] ?? '')) ?> · <?= esc((string) $appt['Appointment_time']) ?>
                    </div>
                  </div>
                  <span class="badge <?= $badgeClass ?>">
                    <?= ucfirst($status) ?>
                  </span>
                </div>

                <div class="timeline__meta">
                  <span class="chip"><?= esc((string) $appt['Appointmentcode']) ?></span>
                </div>

                <?php if (!empty($appt['Symptoms'])): ?>
                  <div class="timeline__symptom">
                    <?= esc((string) $appt['Symptoms']) ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="padding:16px;">No appointments found</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="card">
      <div class="card__header">
        <span class="card__title">My Medical Records</span>
      </div>

      <?php if (!empty($records)): ?>
        <?php foreach ($records as $rec): ?>
          <div class="rec-card">
            <div class="rec-card__top">
              <span class="rec-card__code"><?= esc((string) $rec['RecordCode']) ?></span>
              <span class="rec-card__date"><?= esc((string) $rec['Visit_date']) ?></span>
            </div>
            <div class="rec-card__diagnosis"><?= esc((string) $rec['Diagnosis']) ?></div>
            <div class="rec-card__detail">💊 <?= esc((string) $rec['Prescription']) ?></div>
            <div class="rec-card__detail">🩺 <?= esc((string) $rec['Treatment']) ?></div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="padding:16px;">No medical records available</p>
      <?php endif; ?>
    </div>

  </div>

  <div style="display:flex;flex-direction:column;gap:18px;">

    <?php if (!empty($patient)): ?>
      <div class="card">
        <?php
        $photoUrl = (!empty($patient['Photo']) &&
          file_exists(FCPATH . 'uploads/avatars/' . $patient['Photo']))
          ? base_url('uploads/avatars/' . $patient['Photo'])
          : '';
        ?>

        <div class="profile-card__head">

          <?php if ($photoUrl): ?>
            <img src="<?= esc($photoUrl) ?>" alt="Profile photo"
              style="width:72px;height:72px;border-radius:50%;
                object-fit:cover;margin:0 auto;display:block;">
          <?php else: ?>
            <div class="avatar avatar--lg avatar--green">
              <?= $initials ?>
            </div>
          <?php endif; ?>

          <div class="profile-card__name"><?= esc((string) $patient['Patient_name']) ?></div>
          <div class="profile-card__code">
            <?= esc((string) $patient['Patientcode']) ?>
          </div>
        </div>
      </div>

      <div class="detail-list">
        <div class="detail-row">
          <span>Gender</span>
          <span><?= esc((string) $patient['Gender']) ?></span>
        </div>
        <div class="detail-row">
          <span>Date of Birth</span>
          <span><?= esc((string) $displayBirthdate) ?></span>
        </div>
        <div class="detail-row">
          <span>Phone</span>
          <span><?= esc((string) $patient['Phone']) ?></span>
        </div>
        <div class="detail-row">
          <span>Email</span>
          <span><?= esc((string) $patient['Patient_email']) ?></span>
        </div>
        <div class="detail-row">
          <span>Address</span>
          <span><?= esc((string) $patient['Address']) ?></span>
        </div>
      </div>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card__header">
    <span class="card__title">📅 Book New Appointment</span>
  </div>

  <div class="card__body">
    <form action="<?= base_url('patient/book') ?>" method="post">
      <?= csrf_field() ?>

      <div class="form-group">
        <label>Doctor</label>
        <select name="DoctorCode" class="form-control" required>
          <option value="">Select doctor</option>
          <?php if (!empty($doctors)): ?>
            <?php foreach ($doctors as $doc): ?>
              <option value="<?= esc((string) $doc['DoctorCode']) ?>">
                <?= esc((string) $doc['Doctor_name']) ?> —
                <?= esc((string) $doc['Specialization']) ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Date</label>
        <input type="date" name="Appointment_date"
          min="<?= date('Y-m-d') ?>" required>
      </div>

      <div class="form-group">
        <label>Time</label>
        <input type="time" name="Appointment_time" required>
      </div>

      <div class="form-group">
        <label>Symptoms</label>
        <textarea name="Symptoms"></textarea>
      </div>

      <button type="submit" class="btn btn--primary" style="width:100%;">
        Request Appointment
      </button>

    </form>
  </div>
</div>

</div>
</div>

<?php $this->endSection(); ?>