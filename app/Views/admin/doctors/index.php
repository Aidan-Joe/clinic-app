<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'doctors';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Doctors</h1>
    <p class="page-header__sub">Manage all registered doctors</p>
  </div>
  <div class="page-header__actions">
    <a href="<?= base_url('admin/doctors/create') ?>" class="btn btn--primary">＋ Add Doctor</a>
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
          <th>Specialization</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($doctors)): ?>
          <?php foreach ($doctors as $doc): ?>
          <tr>
            <td class="td--muted"><?= esc($doc['DoctorCode']) ?></td>
            <td>
              <?php
                $initials = implode('', array_map(fn($w) => strtoupper($w[0]),
                  array_slice(explode(' ', preg_replace('/^Dr\.\s*/', '', $doc['Doctor_name'])), 0, 2)
                ));
              ?>
              <div style="display:flex;align-items:center;gap:10px;">
                <div class="avatar avatar--sm avatar--green"><?= $initials ?></div>
                <div class="td--name"><?= esc($doc['Doctor_name']) ?></div>
              </div>
            </td>
            <td><?= esc($doc['Specialization']) ?></td>
            <td class="td--muted"><?= esc($doc['Doctor_email']) ?></td>
            <td class="td--muted"><?= esc($doc['Phone']) ?></td>
            <td>
              <span class="badge <?= $doc['Availability'] === 'Available' ? 'badge--available' : 'badge--occupied' ?>">
                <?= esc($doc['Availability']) ?>
              </span>
            </td>
            <td>
              <div style="display:flex;gap:8px;">
                <a href="<?= base_url('admin/doctors/edit/' . $doc['DoctorCode']) ?>" class="btn btn--ghost" style="padding:6px 12px;font-size:12px;">Edit</a>
                <a href="<?= base_url('admin/doctors/delete/' . $doc['DoctorCode']) ?>"
                   class="btn btn--ghost" style="padding:6px 12px;font-size:12px;color:var(--danger);"
                   onclick="return confirm('Delete this doctor?')">Delete</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center;">No doctors found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
