<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'rooms';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Rooms</h1>
    <p class="page-header__sub">Manage clinic rooms and their status</p>
  </div>
  <div class="page-header__actions">
    <a href="<?= base_url('admin/rooms/create') ?>" class="btn btn--primary">＋ Add Room</a>
  </div>
</div>

<?= $this->include('components/flash') ?>

<div class="grid-cols-3">
  <?php if (!empty($rooms)): ?>
    <?php foreach ($rooms as $room):
      $isOcc = $room['Status'] === 'Occupied';
    ?>
    <div class="room-card">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;">
        <div>
          <div class="room-card__code"><?= esc($room['Room_Code']) ?></div>
          <div class="room-card__name"><?= esc($room['Room_Name']) ?></div>
          <div class="room-card__type"><?= esc($room['Room_Type']) ?></div>
        </div>
        <span class="badge <?= $isOcc ? 'badge--occupied' : 'badge--available' ?>">
          <?= esc($room['Status']) ?>
        </span>
      </div>
      <div style="display:flex;gap:8px;">
        <a href="<?= base_url('admin/rooms/edit/' . $room['Room_Code']) ?>" class="btn btn--ghost" style="padding:6px 12px;font-size:12px;flex:1;justify-content:center;">Edit</a>
        <a href="<?= base_url('admin/rooms/delete/' . $room['Room_Code']) ?>"
           class="btn btn--ghost" style="padding:6px 12px;font-size:12px;color:var(--danger);flex:1;justify-content:center;"
           onclick="return confirm('Delete this room?')">Delete</a>
      </div>
    </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p style="padding:16px;">No rooms found.</p>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
