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

<style>
  .dropdown-toggle {
    outline: 0;
  }

  .nav-flush .nav-link {
    border-radius: 0;
  }

  .btn-toggle {
    display: inline-flex;
    align-items: center;
    padding: .25rem .5rem;
    font-weight: 600;
    color: rgba(0, 0, 0, .65);
    background-color: transparent;
    border: 0;
  }

  .btn-toggle:hover,
  .btn-toggle:focus {
    color: rgba(0, 0, 0, .85);
    background-color: #d2f4ea;
  }

  .btn-toggle::before {
    width: 1.25em;
    line-height: 0;
    content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
    transition: transform .35s ease;
    transform-origin: .5em 50%;
  }

  .btn-toggle[aria-expanded="true"] {
    color: rgba(0, 0, 0, .85);
  }

  .btn-toggle[aria-expanded="true"]::before {
    transform: rotate(90deg);
  }

  .btn-toggle-nav a {
    display: inline-flex;
    padding: .1875rem .5rem;
    margin-top: .125rem;
    margin-left: 1.25rem;
    text-decoration: none;
  }

  .btn-toggle-nav a:hover,
  .btn-toggle-nav a:focus {
    background-color: #d2f4ea;
  }

  .scrollarea {
    overflow-y: auto;
  }

  .fw-semibold {
    font-weight: 600;
  }

  .lh-tight {
    line-height: 1.25;
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
            <a href="<?= URLROOT ?>/admins/dashboard" class="nav-link nav-link-custom link-dark <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : '' ?>">
              <?= $language['nav_dashboard'] ?>
            </a>
          </li>
          <hr>

          <li class="nav-item">
            <a href="<?= URLROOT ?>/reservations" class="nav-link nav-link-custom link-dark <?= isset($data['reservations']) ? 'active' : '' ?>">
              <?= $language['nav_reservations'] ?> <span class="badge bg-secondary rounded-pill"><?= Statistics::reservationsCount() ?></span>
            </a>
          </li>
          <hr>

          <li class="mb-1">
            <a class="btn btn-toggle align-items-center rounded nav-link nav-link-custom link-dark collapsed <?= isset($data['borrowings']) || isset($data['add_borrowing']) ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#borrowings-collapse" aria-expanded="<?= isset($data['borrowings']) || isset($data['add_borrowing']) ? 'true' : 'false' ?>">
              <?= $language['nav_borrowings'] ?>
            </a>
            <div class="collapse <?= isset($data['borrowings']) || isset($data['add_borrowing']) ? 'show' : '' ?>" id="borrowings-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="<?= URLROOT ?>/borrowings/add" class="link-dark rounded border-info <?= isset($data['add_borrowing']) ? 'border-start' : '' ?>"><?= $language['nav_borrowings_add'] ?></a></li>
                <li>
                  <a href="<?= URLROOT ?>/borrowings" class="link-dark rounded border-info <?= isset($data['borrowings']) && $data['status'] === 'not returned' ? 'border-start' : '' ?>">
                    <?= $language['nav_borrowings_not'] ?>&nbsp;&nbsp; <span class="badge bg-secondary rounded-pill"><?= Statistics::NotReturnedBorrowingsCount() ?></span>
                  </a>
                </li>
                <li><a href="<?= URLROOT ?>/borrowings/archive" class="link-dark rounded border-info <?= isset($data['borrowings']) && $data['status'] === 'returned' ? 'border-start' : '' ?>"><?= $language['nav_borrowings_archive'] ?></a></li>

              </ul>
            </div>
          </li>
          <hr>

          <li class="mb-1">

            <a class="btn btn-toggle align-items-center rounded nav-link nav-link-custom link-dark collapsed <?= isset($data['books']) || isset($data['add_book']) || isset($data['edit_book']) || isset($data['add_book_copy']) ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#books-collapse" aria-expanded="<?= isset($data['books']) || isset($data['add_book']) ||  isset($data['edit_book']) || isset($data['add_book_copy']) ? 'true' : 'false' ?>">
              <?= $language['nav_books'] ?>&nbsp;&nbsp; <span title="<?= $language['nav_books_notif_title'] ?>" class="badge bg-secondary rounded-pill"><?= Statistics::OutOfStockBooksCount() ?></span>
            </a>
            <div class="collapse <?= isset($data['books']) || isset($data['add_book']) || isset($data['edit_book']) || isset($data['add_book_copy']) ? 'show' : '' ?>" id="books-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="<?= URLROOT ?>/books/add" class="link-dark rounded border-info <?= isset($data['add_book']) ? 'border-start' : '' ?>"><?= $language['nav_books_add'] ?></a></li>
                <li>
                  <a href="<?= URLROOT ?>/books" class="link-dark rounded border-info <?= isset($data['books']) || isset($data['edit_book']) || isset($data['add_book_copy']) ? 'border-start' : '' ?>">
                    <?= $language['nav_books_all'] ?>
                  </a>
                </li>


              </ul>
            </div>
          </li>

          <hr>

          <li class="nav-item">
            <a href="<?= URLROOT ?>/borrowers" class="nav-link nav-link-custom link-dark <?= isset($data['borrowers']) || isset($data['borrower']) ? 'active' : '' ?>">
              <?= $language['nav_borrowers'] ?>
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
      <?= flash('book') ?>
      <?php if (isset($data['reservations'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/reservations/reservations.inc.php' ?>
      <?php elseif (isset($data['borrowings'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/borrowings/borrowings.inc.php' ?>
      <?php elseif (isset($data['add_borrowing'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/borrowings/addborrowing.inc.php' ?>
      <?php elseif (isset($data['books'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/books/books.inc.php' ?>
      <?php elseif (isset($data['add_book']) || isset($data['edit_book'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/books/addbook.inc.php' ?>
      <?php elseif (isset($data['add_book_copy']) || isset($data['edit_book'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/books/addcopy.inc.php' ?>
      <?php elseif (isset($data['borrowers'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/borrowers/borrowers.inc.php' ?>
      <?php elseif (isset($data['borrower'])) : ?>
        <?php require_once APPROOT . '/views/admins/inc/borrowers/borrowerdetail.inc.php' ?>
      <?php else : ?>
        <h6></h6>
        <p></p>
        <?php require_once APPROOT . '/views/admins/inc/dashboard/dashboard.inc.php' ?>
      <?php endif ?>
    </main>
  </div>

</section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>