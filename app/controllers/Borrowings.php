<?php

class borrowings extends Controller
{

  private Borrowing $borrowingModel;
  private Book $bookModel;

  public function __construct()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }

    $this->borrowingModel = $this->model('Borrowing');
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
      ];

      if (empty($data['barcode'])) {
        $data['barcode_err'] = 'Invalid borrower barcode';
      }
      if (empty($data['inv'])) {
        $data['inv_err'] = 'Please scan book inventory number';
      }

      // Make sure there is no error
      if (empty($data['barcode_err']) && empty($data['inv_err'])) {
        if ($this->borrowingModel->add($data['barcode'], $data['inv'])) {
          flash('borrowing', 'Book borrowed successfully!');
          redirect('borrowings');
        } else {
          flash('reservation', 'Something wrong!', 'alert alert-danger');
        }
      } else {
        var_dump($_POST);
        die('here');
        //$borrowings = $this->borrowingModel->getAllReservations();
        $data['borrowings'] = '';
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
