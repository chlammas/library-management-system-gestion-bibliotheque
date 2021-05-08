<?php require_once APPROOT . '/views/inc/header-admin.php'; ?>

<style type="text/css">
  li .submenu {
    list-style: none;
    margin: 0;
    padding: 0;
    padding-left: 1rem;
    padding-right: 1rem;
  }

  aside .nav-link {
    font-weight: 500;
    color: var(--bs-dark);
    margin-top: 10px;
  }

  .row {
    margin-right: 0
  }

  .rounded-pill {
    float: right;
  }

  .btn-outline-danger:hover {
    color: #fff;
    background-color: #dc3545;
  }

  .btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
  }
</style>
<section class="section-content py-3">
  <div class="row">
    <aside class="col-lg-3">

      <div class="d-flex flex-column p-3 bg-light">
        <!-- <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
          <span class="fs-4">Sidebar</span>
        </a>
        <hr> -->
        <ul class="nav nav-pills flex-column mb-auto">
          <!-- <li class="nav-item">
      <a href="#" class="nav-link active">
        Home
      </a>
      </li> -->
          <li class="nav-item">
            <a href="#" class="nav-link nav-link-custom link-dark active">
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URLROOT ?>/reservations" class="nav-link nav-link-custom link-dark">
              Reservations <span class="badge bg-secondary rounded-pill"><?= Statistics::reservationsCount() ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URLROOT ?>/borrowings" class="nav-link nav-link-custom link-dark">
              Borrowings <span class="badge bg-secondary rounded-pill"><?= Statistics::NotReturnedBorrowingsCount() ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URLROOT ?>/books" class="nav-link nav-link-custom link-dark">
              Books
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-link-custom link-dark">
              Borrowers
            </a>
          </li>
        </ul>
        <hr>
        <!-- <div class="dropdown">
          <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle me-2">
            <strong>mdo</strong>
          </a>
          <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div> -->
      </div>
    </aside>
    <main class="col-lg-9">
      <?= flash('borrowing') ?>
      <?= flash('reservation') ?>
      <?php if (isset($data['reservations'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/reservations.inc.php' ?>
      <?php elseif (isset($data['borrowings'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/borrowings.inc.php' ?>
      <?php else : ?>
        <h6>Demo for sidebar nav menu links. <br> Based on Bootstrap 5 CSS framework. </h6>
        <p>For this demo page you should connect to the internet to receive files from CDN like Bootstrap5 CSS, Bootstrap5 JS</p>

        <p class="text-muted"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>

      <?php endif ?>
    </main>
  </div>
</section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>