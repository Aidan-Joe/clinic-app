<?php /** @var string $pageTitle */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle ?? 'Dashboard') ?> — MediCore</title>
  <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
  <?= $this->renderSection('head') ?>
</head>
<body>

<div class="layout layout--topnav">

  <?= $this->include('components/topnav') ?>

  <main class="main-content" style="max-width:1100px; margin-left:auto; margin-right:auto; padding-left:24px; padding-right:24px;">
    <?= $this->renderSection('content') ?>
  </main>

</div>

<?= $this->renderSection('scripts') ?>
</body>
</html>
