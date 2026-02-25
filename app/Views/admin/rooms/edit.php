<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'rooms';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Edit Room</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/rooms') ?>" class="card__action">← Back to Rooms</a></p>
  </div>
</div>

<div class="card" style="max-width:480px;">
  <div class="card__body">
    <form action="<?= base_url('admin/rooms/update/' . $room['Room_Code']) ?>" method="post">
      <?= csrf_field() ?>

      <div class="form-group">
        <label class="form-label">Room Code</label>
        <input type="text" class="form-control" value="<?= esc($room['Room_Code']) ?>" disabled>
      </div>
      <div class="form-group">
        <label class="form-label">Room Name</label>
        <input type="text" name="Room_Name" class="form-control" value="<?= esc($room['Room_Name']) ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Room Type</label>
        <select name="Room_Type" class="form-control" required>
          <?php foreach (['Examination Room','Consultation Room','Treatment Room','Ward','ICU','Operating Room'] as $type): ?>
            <option value="<?= $type ?>" <?= $room['Room_Type'] === $type ? 'selected' : '' ?>><?= $type ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="Status" class="form-control">
          <option value="Available" <?= $room['Status'] === 'Available' ? 'selected' : '' ?>>Available</option>
          <option value="Occupied"  <?= $room['Status'] === 'Occupied'  ? 'selected' : '' ?>>Occupied</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Update Room</button>
        <a href="<?= base_url('admin/rooms') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
