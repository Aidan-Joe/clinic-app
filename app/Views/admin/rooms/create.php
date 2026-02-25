<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$sidebarRole = 'admin';
$activeNav   = 'rooms';
?>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Add Room</h1>
    <p class="page-header__sub"><a href="<?= base_url('admin/rooms') ?>" class="card__action">← Back to Rooms</a></p>
  </div>
</div>

<div class="card" style="max-width:480px;">
  <div class="card__body">
    <form action="<?= base_url('admin/rooms/store') ?>" method="post">
      <?= csrf_field() ?>

      <div class="form-group">
        <label class="form-label">Room Code</label>
        <input type="text" name="Room_Code" class="form-control" placeholder="R-07" required>
      </div>
      <div class="form-group">
        <label class="form-label">Room Name</label>
        <input type="text" name="Room_Name" class="form-control" placeholder="Cardiology Ward B" required>
      </div>
      <div class="form-group">
        <label class="form-label">Room Type</label>
        <select name="Room_Type" class="form-control" required>
          <option value="">Select type</option>
          <option value="Examination Room">Examination Room</option>
          <option value="Consultation Room">Consultation Room</option>
          <option value="Treatment Room">Treatment Room</option>
          <option value="Ward">Ward</option>
          <option value="ICU">ICU</option>
          <option value="Operating Room">Operating Room</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <button type="submit" class="btn btn--primary">Save Room</button>
        <a href="<?= base_url('admin/rooms') ?>" class="btn btn--ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
