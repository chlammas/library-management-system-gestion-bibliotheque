<?php

class borrowings extends Controller
{

  private Borrowing $borrowingModel;
  private Reservation $reservationModel;
  private Book $bookModel;

  public function __construct()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }

    $this->borrowingModel = $this->model('Borrowing');
    $this->reservationModel = $this->model('Reservation');
    $this->bookModel = $this->model('Book');
  }

  public function index()
  {
    $borrowings = $this->borrowingModel->getAllBorrowings();

    $data = [
      'borrowings' => $borrowings,
    ];
    $this->view('admins/index', $data);
  }

  public function search($queryname)
  {
    $data = [];
    echo 'books of ' . $queryname;
    $this->view('borrowings/index', $data);
  }

  public function add()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'barcode' => isset($_POST['barcode']) ? trim($_POST['barcode']) : '',
        'barcode_err' => '',
        'inv' => isset($_POST['inv']) ? trim($_POST['inv']) : '',
        'inv_err' => '',
        'fullname' => isset($_POST['fullname']) ? trim($_POST['fullname']) : '',
        'general_err' => ''
      ];

      if (empty($data['barcode'])) {
        $data['barcode_err'] = 'Invalid borrower barcode';
      }
      if (empty($data['inv'])) {
        $data['inv_err'] = 'Please scan book inventory number';
      }


      if (strpos($_SERVER["HTTP_REFERER"], 'reservations') !== false) {
        $reservations = $this->reservationModel->getAllReservations();
        $data['reservations'] = $reservations;
      } else {
        $borrowings = $this->borrowingModel->getAllBorrowings();
        $data['borrowings'] = $borrowings;
      }

      // Make sure there is no error
      if (empty($data['barcode_err']) && empty($data['inv_err'])) {
        try {
        $this->borrowingModel->add($data['barcode'], $data['inv']);
          flash('borrowing', 'Book borrowed successfully!');
          redirect('borrowings');
        
      } catch (PDOException $e) {
        $expectedError = 'This book copy is already borrowed !';
        if (strpos($e->getMessage(), $expectedError) !== false) {
          flash('reservation', $expectedError, 'alert alert-danger');
          $data['inv_err'] = $expectedError;
        } else {
          flash('reservation', $e->getMessage(), 'alert alert-danger');
        }
          $this->view('admins/index', $data);
      }
      } else {
        $err_msg = '<ul>';
        $err_msg .= $data['barcode_err'] ?  '<li>' . $data['barcode_err'] . '</li>' : '';
        $err_msg .= $data['inv_err'] ?  '<li>' . $data['inv_err'] . '</li>' : '';
        $err_msg .= '</ul>';

        flash('borrowing', $err_msg, 'alert alert-danger');
        $this->view('admins/index', $data);
      }
    } else {
      $reservations = $this->reservationModel->getAllReservations();
      $data['reservations'] = $reservations;
      $this->view('admins/index', $data);
    }
  }

  public function detail($isbn)
  {
    echo 'detail of book' . $isbn;
  }
}
