<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — MediCore</title>
  <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
  <style>
    .login-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--green-900) 0%, var(--green-700) 60%, var(--green-500) 100%);
    }
    .login-box {
      width: 100%;
      max-width: 400px;
      padding: 0 16px;
    }
    .login-brand {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 8px;
    }
    .login-tagline {
      text-align: center;
      font-size: 13px;
      color: rgba(255,255,255,0.6);
      margin-bottom: 28px;
    }
    .login-logo-text {
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 22px;
      color: var(--white);
      letter-spacing: -0.2px;
    }
    .login-logo-text em { font-style: italic; color: var(--green-300); }
    .alert-error {
      background: var(--danger-light);
      color: var(--danger);
      padding: 10px 14px;
      border-radius: var(--radius-sm);
      margin-bottom: 16px;
      font-size: 13px;
      border-left: 3px solid var(--danger);
    }
    .login-footer {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: rgba(255,255,255,0.4);
    }
  </style>
</head>
<body>

<div class="login-wrap">
  <div class="login-box">

    <div class="login-brand">
      <div class="logo-icon">🏥</div>
      <div class="login-logo-text">Clinic<em>App</em></div>
    </div>
    <p class="login-tagline">Sign in to your account</p>

    <div class="card">
      <div class="card__body">

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/login') ?>" method="post">
          <?= csrf_field() ?>

          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= old('email') ?>" required autocomplete="email">
          </div>

          <div class="form-group" style="margin-bottom:20px;">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button type="submit" class="btn btn--primary" style="width:100%;">Sign In →</button>
        </form>

      </div>
    </div>

    <p class="login-footer">MediCore Clinic Management System</p>

  </div>
</div>

</body>
</html>
