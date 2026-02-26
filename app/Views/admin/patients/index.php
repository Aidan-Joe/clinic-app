<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'patients';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Patients</h1>
    <p class="page-header__sub">Manage all registered patients</p>
  </div>
  <div class="page-header__actions">
    <a href="<?= base_url('admin/patients/create') ?>" class="btn btn--primary">＋ Add Patient</a>
  </div>
</div>

<?= $this->include('components/flash') ?>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Birthdate</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($patients)): ?>
          <?php foreach ($patients as $p): ?>
          <tr>
            <td class="td--muted"><?= esc($p['Patientcode']) ?></td>
            <td>
              <?php
                $initials = implode('', array_map(fn($w) => strtoupper($w[0]),
                  array_slice(explode(' ', $p['Patient_name']), 0, 2)
                ));
                $ptPhotoUrl = (fn($f) => $f && file_exists(FCPATH . 'uploads/avatars/' . $f) ? base_url('uploads/avatars/' . $f) : '')($p['Photo'] ?? null);
              ?>
              <div style="display:flex;align-items:center;gap:10px;">
                <?php if ($ptPhotoUrl): ?>
                  <img src="<?= esc($ptPhotoUrl) ?>" alt=""
                       style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                <?php else: ?>
                  <div class="avatar avatar--sm avatar--teal"><?= $initials ?></div>
                <?php endif; ?>
                <div class="td--name"><?= esc($p['Patient_name']) ?></div>
              </div>
            </td>
            <td><?= esc($p['Gender']) ?></td>
            <td class="td--muted"><?= esc($p['Phone']) ?></td>
            <td class="td--muted"><?= esc($p['Patient_email']) ?></td>
            <td class="td--muted"><?= esc($p['Birthdate']) ?></td>
            <td class="td--muted"><?= esc($p['Address']) ?></td>
            <td>
              <div style="display:flex;gap:8px;">
                <a href="<?= base_url('admin/patients/edit/' . $p['Patientcode']) ?>" class="btn btn--ghost" style="padding:6px 12px;font-size:12px;">Edit</a>
                <a href="<?= base_url('admin/patients/delete/' . $p['Patientcode']) ?>"
                   class="btn btn--ghost" style="padding:6px 12px;font-size:12px;color:var(--danger);"
                   onclick="return confirm('Delete this patient?')">Delete</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="8" style="text-align:center;">No patients found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
