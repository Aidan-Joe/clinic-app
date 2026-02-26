<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'doctor';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">My Patients</h1>
    <p class="page-header__sub">Patients who have visited you</p>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Phone</th>
          <th>Total Visits</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($patients)): ?>
          <?php foreach ($patients as $p): ?>
            <tr>
              <td class="td--muted"><?= esc($p['Patientcode']) ?></td>
              <td>
                <?php
                $initials = implode('', array_map(
                  fn($w) => strtoupper($w[0]),
                  array_slice(explode(' ', $p['Patient_name']), 0, 2)
                ));
                ?>
                <div style="display:flex;align-items:center;gap:10px;">
                  <?php
                  $photoUrl = (!empty($p['Photo']) &&
                    file_exists(FCPATH . 'uploads/avatars/' . $p['Photo']))
                    ? base_url('uploads/avatars/' . $p['Photo'])
                    : '';
                  ?>

                  <?php if ($photoUrl): ?>
                    <img src="<?= esc($photoUrl) ?>" alt=""
                      style="width:28px;height:28px;border-radius:50%;
              object-fit:cover;flex-shrink:0;">
                  <?php else: ?>
                    <div class="avatar avatar--sm avatar--teal">
                      <?= $initials ?>
                    </div>
                  <?php endif; ?>
                  <div class="td--name"><?= esc($p['Patient_name']) ?></div>
                </div>
              </td>
              <td><?= esc($p['Gender']) ?></td>
              <td class="td--muted"><?= esc($p['Phone']) ?></td>
              <td>
                <span class="chip"><?= esc($p['visit_count']) ?> visit<?= $p['visit_count'] != 1 ? 's' : '' ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" style="text-align:center;">No patients yet.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>