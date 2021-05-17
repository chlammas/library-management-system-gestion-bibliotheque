<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="<?= URLROOT ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= URLROOT ?>/fontawesome/css/all.css">
  <script src="<?= URLROOT ?>/js/chart.min.js"></script>
  <link rel="stylesheet" href="<?= URLROOT ?>/css/style.css">
  <title><?= SITENAME ?></title>
</head>

<body>

  <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="<?php echo URLROOT ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32">
        <use xlink:href="#bootstrap"></use>
      </svg>
      <span class="fs-4">Université Chouaib Doukkali</span>
    </a>
    <?php require_once APPROOT . '/views/inc/navbar.php'; ?>
  </header>