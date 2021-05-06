<?php

class Borrowers extends Controller
{
  private Borrower $borrowerModel;
  private Borrowing $borrowingModel;
  private Reservation $reservationModel;
  private Book $bookModel;

  public function __construct()
  {
    $this->borrowerModel = $this->model('Borrower');
    $this->borrowingModel = $this->model('Borrowing');
    $this->reservationModel = $this->model('Reservation');
    $this->bookModel = $this->model('Book');
  }

  public function index()
  {
    if (!isBorrowerLoggedIn()) {
      redirect('');
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


  public function logout()
  {
    userLogout();
  }
}
