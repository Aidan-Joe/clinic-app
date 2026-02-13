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

<div class="layout">

  <?= $this->include('components/sidebar') ?>

  <main class="main-content">
    <?= $this->renderSection('content') ?>
  </main>

</div>

<?= $this->renderSection('scripts') ?>
</body>
</html>
