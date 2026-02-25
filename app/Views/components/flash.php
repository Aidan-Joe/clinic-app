<?php if (session()->getFlashdata('success')): ?>
  <div style="background:var(--success-light);color:var(--success);padding:12px 18px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13px;border-left:3px solid var(--success);">
    ✓ <?= esc(session()->getFlashdata('success')) ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div style="background:var(--danger-light);color:var(--danger);padding:12px 18px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13px;border-left:3px solid var(--danger);">
    ✗ <?= esc(session()->getFlashdata('error')) ?>
  </div>
<?php endif; ?>
