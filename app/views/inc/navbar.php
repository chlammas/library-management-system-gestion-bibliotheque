<nav class="nav">
  <ul class="nav nav-pills">
    <?php if (isBorrowerLoggedIn()) : ?>
      <!-- <li class="nav-item"><a href="#" class="nav-link">Welcome <b><?= $_SESSION['borrower_firstname'] . ' ' . $_SESSION['borrower_lastname'] ?></b></a></li>
      <li class="nav-item"><a href="<?php echo URLROOT ?>/borrowers/logout" class="nav-link">Logout</a></li> -->
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="<?= $_SESSION['borrower_firstname'] . ' ' . $_SESSION['borrower_lastname'] ?>" width="32" height="32" class="rounded-circle me-2">
          <strong><?= $_SESSION['borrower_firstname'] . ' ' . $_SESSION['borrower_lastname'] ?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <!-- <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li> 
          <li>
            <hr class="dropdown-divider">
          </li>-->
          <li><a class="dropdown-item" href="<?php echo URLROOT ?>/borrowers/logout">Logout</a></li>
        </ul>
      </div>
    <?php elseif (isAdminLoggedIn()) : ?>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="<?= $_SESSION['admin_firstname'] . ' ' . $_SESSION['admin_lastname'] ?>" width="32" height="32" class="rounded-circle me-2">
          <strong><?= $_SESSION['admin_firstname'] . ' ' . $_SESSION['admin_lastname'] ?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="<?php echo URLROOT ?>/admins/logout">Logout</a></li>
        </ul>
      </div>

    <?php else : ?>
      <li class="nav-item"><a href="<?php echo URLROOT ?>" class="nav-link nav-link-custom active">Home</a></li>
      <li class="nav-item"><a href="<?php echo URLROOT ?>/pages/about" class="nav-link nav-link-custom">about</a></li>
      <li class="nav-item"><a href="<?php echo URLROOT ?>/pages/about" class="nav-link nav-link-custom">Contact us</a></li>
    <?php endif ?>

  </ul>
</nav>