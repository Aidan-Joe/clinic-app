<?php
$this->extend('layouts/main');
$this->section('content');

$sidebarRole = 'doctor';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">My Schedule</h1>
    <p class="page-header__sub"><?= date('l, j F Y') ?></p>
  </div>
</div>

<div class="stats-grid stats-grid--4">

  <div class="stat-card">
    <div class="stat-card__icon">📅</div>
    <div class="stat-card__value"><?= esc($stats['appointments_today']) ?></div>
    <div class="stat-card__label">Today's Appointments</div>
  </div>

  <div class="stat-card">
    <div class="stat-card__icon">✅</div>
    <div class="stat-card__value"><?= esc($stats['completed']) ?></div>
    <div class="stat-card__label">Completed Today</div>
  </div>

  <div class="stat-card">
    <div class="stat-card__icon">👥</div>
    <div class="stat-card__value"><?= esc($stats['total_patients']) ?></div>
    <div class="stat-card__label">Total My Patients</div>
  </div>

  <div class="stat-card stat-card--warn">
    <div class="stat-card__icon">📋</div>
    <div class="stat-card__value"><?= esc($stats['records_pending']) ?></div>
    <div class="stat-card__label">Records Pending</div>
  </div>

</div>

<div class="grid-cols-2">

  <!-- LEFT SIDE -->
  <div style="display:flex;flex-direction:column;gap:18px;">

    <!-- QUEUE -->
    <div class="card">
      <div class="card__header">
        <span class="card__title">Today's Patient Queue</span>
      </div>

      <div class="timeline">

        <?php if (!empty($queue)): ?>
          <?php foreach ($queue as $row):

            $badgeMap = [
              'completed' => 'badge--completed',
              'scheduled' => 'badge--scheduled',
              'cancelled' => 'badge--cancelled',
              'next' => 'badge--next'
            ];

            $status = (string) ($row['Status'] ?? '');
            $badgeClass = $badgeMap[$status] ?? 'badge--scheduled';
            $badgeLabel = $status === 'next' ? '→ Next' : ucfirst($status);
            $isHighlight = $status === 'next';
          ?>

            <div class="timeline__item" <?= $isHighlight ? 'style="background:var(--accent-xlight)"' : '' ?>>
              <div class="timeline__side">
                <div class="timeline__date"><?= esc((string) $row['Appointment_time']) ?></div>
                <div class="timeline__line"></div>
              </div>

              <div class="timeline__body">
                <div style="display:flex;justify-content:space-between;">
                  <div>
                    <?php
                    $initials = implode('', array_map(
                      fn($w) => strtoupper($w[0]),
                      array_slice(explode(' ', $row['Patient_name']), 0, 2)
                    ));

                    $photoUrl = (!empty($row['Photo']) &&
                      file_exists(FCPATH . 'uploads/avatars/' . $row['Photo']))
                      ? base_url('uploads/avatars/' . $row['Photo'])
                      : '';
                    ?>

                    <div style="display:flex;align-items:center;gap:10px;">
                      <?php if ($photoUrl): ?>
                        <img src="<?= esc($photoUrl) ?>" alt=""
                          style="width:36px;height:36px;border-radius:50%;
                object-fit:cover;flex-shrink:0;">
                      <?php else: ?>
                        <div class="avatar avatar--sm avatar--teal">
                          <?= $initials ?>
                        </div>
                      <?php endif; ?>

                      <div>
                        <div class="timeline__doctor">
                          <?= esc((string) $row['Patient_name']) ?>
                        </div>
                        <div class="timeline__spec" style="color:var(--gray-400)">
                          <?= esc((string) $row['Symptoms']) ?>
                        </div>
                      </div>
                    </div>
                    <div class="timeline__spec" style="color:var(--gray-400)">
                      <?= esc((string) $row['Symptoms']) ?>
                    </div>
                  </div>
                  <span class="badge <?= $badgeClass ?>">
                    <?= $badgeLabel ?>
                  </span>
                </div>

                <div class="timeline__meta">
                  <span class="chip">🏠 <?= esc((string) ($row['Room_Code'] ?? '-')) ?></span>
                  <span class="chip"><?= esc((string) $row['Appointmentcode']) ?></span>
                </div>
              </div>
            </div>

          <?php endforeach; ?>
        <?php else: ?>
          <p style="padding:16px;">No appointments today</p>
        <?php endif; ?>

      </div>
    </div>

    <div class="card">
      <div class="card__header">
        <span class="card__title">Recent Medical Records</span>
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

            <?php if (!empty($recentRecords)): ?>
              <?php foreach ($recentRecords as $rec): ?>
                <tr>
                  <td class="td--muted"><?= esc((string) $rec['RecordCode']) ?></td>
                  <td>
                    <div class="td--name"><?= esc((string) $rec['Patient_name']) ?></div>
                    <div class="td--muted"><?= esc((string) $rec['Patientcode']) ?></div>
                  </td>
                  <td class="td--muted"><?= esc((string) $rec['Visit_date']) ?></td>
                  <td><?= esc((string) $rec['Diagnosis']) ?></td>
                  <td class="td--muted">
                    <?= esc((string) $rec['Prescription']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" style="text-align:center;">No records found</td>
              </tr>
            <?php endif; ?>

          </tbody>
        </table>
      </div>
    </div>

  </div>

  <div style="display:flex;flex-direction:column;gap:18px;">

    <?php if (!empty($nextPatient)):
      $next = $nextPatient;
      $initials = implode('', array_map(
        fn($w) => strtoupper($w[0]),
        array_slice(explode(' ', $next['Patient_name']), 0, 2)
      ));
      $nextPhotoUrl = (fn($f) => $f && file_exists(FCPATH . 'uploads/avatars/' . $f) ? base_url('uploads/avatars/' . $f) : '')($next['Photo'] ?? null);
    ?>
      <div class="card">
        <div class="card__header">
          <span class="card__title">Next Patient</span>
        </div>

        <div class="card__body">
          <div style="display:flex;align-items:center;gap:12px;">
            <?php if ($nextPhotoUrl): ?>
              <img src="<?= esc($nextPhotoUrl) ?>" alt=""
                style="width:48px;height:48px;border-radius:50%;object-fit:cover;flex-shrink:0;">
            <?php else: ?>
              <div class="avatar avatar--lg avatar--teal"><?= $initials ?></div>
            <?php endif; ?>
            <div>
              <div style="font-weight:600;"><?= esc((string) $next['Patient_name']) ?></div>
              <div class="td--muted">
                <?= esc((string) $next['Patientcode']) ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!empty($myRoom)):
      $isOcc = $myRoom['Status'] === 'Occupied';
    ?>
      <div class="card">
        <div class="card__header">
          <span class="card__title">My Room</span>
        </div>

        <div class="card__body">
          <div class="room-mini">
            <div>
              <div class="room-mini__code"><?= esc((string) $myRoom['Room_Code']) ?></div>
              <div class="room-mini__name">
                <?= esc((string) $myRoom['Room_Name']) ?> · <?= esc((string) $myRoom['Room_Type']) ?>
              </div>
            </div>
          </div>

          <div class="room-status-row">
            <span class="badge <?= $isOcc ? 'badge--occupied' : 'badge--available' ?>">
              <?= esc((string) $myRoom['Status']) ?>
            </span>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>

</div>

<?php $this->endSection(); ?>