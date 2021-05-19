<?php

class Borrowers extends Controller
{
  private Borrower $borrowerModel;
  private Borrowing $borrowingModel;
  private Reservation $reservationModel;
  private Book $bookModel;
  private Sanction $sanctionModel;

  public function __construct()
  {
    $this->borrowerModel = $this->model('Borrower');
    $this->borrowingModel = $this->model('Borrowing');
    $this->reservationModel = $this->model('Reservation');
    $this->bookModel = $this->model('Book');
    $this->sanctionModel = $this->model('Sanction');
  }

  public function index()
  {
    if (isAdminLoggedIn()) {
      redirect('borrowers/all');
    } elseif (!isBorrowerLoggedIn()) {
      redirect('');
    }
    $sanctions = $this->sanctionModel->findSanctionsByUserCode($_SESSION['borrower_barcode']);
    if ($sanctions) {
      $data = [
        'sanction' => $sanctions[0],
      ];
      $this->view('borrowers/index', $data);
    }
    $reservation = $this->reservationModel->findReservationByUserCode($_SESSION['borrower_barcode']);

    $borrowing = $this->borrowingModel->findBorrowingByUserCode($_SESSION['borrower_barcode'], false);


    $data = [
      'borrowing' => $borrowing,
      'reservation' => $reservation,
      'books' => '',
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
      if (!empty(trim($_POST['query']))) {
        $books = $this->bookModel->findAvailableBooks($_POST['query'], false);
        $data['books'] = $books;
      }
    }

    $this->view('borrowers/index', $data);
  }

  public function login($barcode = null)
  {

    [$success, $data] = validateLoginRequest($_SERVER['REQUEST_METHOD'], $_POST);
    if ($success === true) {

      $loggedInUser = $this->borrowerModel->findBorrowerByBarCode($data['barcode']);

      if ($loggedInUser) {
        // Create session
        createUserSession($loggedInUser);

        redirect('borrowers');
      } else {
        $data['barcode_err'] = 'Account not found!';
        $this->view('pages/index', $data);
      }
    } else {
      $this->view('pages/index', $data);
    }
  }

  public function findBorrowerByBarCode()
  {
    global $language;
    if (!isAdminLoggedIn()) {
      redirect('');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
      $borrower = $this->borrowerModel->findBorrowerByBarCode(Trim($_POST['code']));
      if ($borrower) {
        $alert = 'success';
        $msg = '';
        $sanctionsCount = 0;
        $sanctions = $this->sanctionModel->findSanctionsByUserCode($borrower->Barcode); // Check for applied sactions
        if ($sanctions) {
          $alert = 'danger';
          $msg = 'This borrower is blocked, please unblock them before completing the proccess!';
          $sanctionsCount = count($this->sanctionModel->findSanctionsByUserCode($borrower->Barcode, false));
        } else {
          $sanctions = $this->sanctionModel->findSanctionsByUserCode($borrower->Barcode, false); // Check for sanctions in history
          if ($sanctions) {
            $alert = 'warning';
            $sanctionsCount = Count($sanctions);
          }
        }
        echo '
              <div class="card border-' . $alert . ' mb-3 borrower-card" style="max-width: 540px;">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="' . URLROOT . '/img/borrower.png" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">' . $borrower->Firstname . ' ' . $borrower->Lastname . '</h5>
                    <ul class="card-text list-unstyled fw-normal pb-1">
                      <li>' . $language['table_barcode'] . '<small class="text-muted"> : ' . $borrower->Barcode . '</small></li>
                      <li>' . $language['table_cin'] . ' : <small class="text-muted">' . $borrower->CIN . '</small></li>
                      <li>' . $language['table_program'] . ' : <small class="text-muted">' . $borrower->Program . '</small></li>
                      <li class="alert-' . $alert . '">' . $language['table_sanctions'] . ' : <small class="text-muted">' . $sanctionsCount . '</small></li>
                    </ul>
                    <p class="card-text"><small class="text-muted">' . $msg . '</small></p>
                  </div>
                </div>
              </div>
            </div>
      
      ';
      } else {
        http_response_code(404);
        echo 'Borrower not found';
      }
    }
  }
  public function logout()
  {
    userLogout();
  }

  public function all()
  {
    $data = [
      'borrowers' => '',
      'query' => isset($_GET['query']) ? trim($_GET['query']) : '',
      'filterby' => isset($_GET['filterby']) ? trim($_GET['filterby']) : '',
      'orderby' => isset($_GET['orderby']) ? trim($_GET['orderby']) : 'Barcode',
    ];

    $borrowers = $this->borrowerModel->findBorrowers($data['query'], $data['filterby'], $data['orderby']);
    $data['borrowers'] = $borrowers;
    $this->view('admins/index', $data);
  }

  public function detail($barcode = null)
  {
    if (is_null($barcode)) {
      redirect('borrowers');
    }
    $data = [
      'borrower' => '',
      'borrower_borrowings' => '',
      'borrower_sanctions' => '',
    ];
    $borrower = $this->borrowerModel->findBorrowerByBarCode($barcode);
    $borrowings = $this->borrowingModel->findBorrowingByUserCode($barcode);
    $sanctions = $this->sanctionModel->findSanctionsByUserCode($barcode, false);
    if ($borrower) {
      $data['borrower'] = $borrower;
      $data['borrower_borrowings'] = $borrowings;
      $data['borrower_sanctions'] = $sanctions;
      $this->view('admins/index', $data);
    } else {
      redirect('borrowers');
    }
  }
}
