<?php

class borrowings extends Controller
{

  private Borrowing $borrowingModel;
  private Reservation $reservationModel;
  private Sanction $sanctionModel;
  private Book $bookModel;

  public function __construct()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }

    $this->borrowingModel = $this->model('Borrowing');
    $this->reservationModel = $this->model('Reservation');
    $this->sanctionModel = $this->model('Sanction');
    $this->bookModel = $this->model('Book');
  }

  public function index()
  {
    $query = null;
    $orderby = 'BorrowingDate';
    $delayed = false;
    $desc = false;
    if (isset($_GET['query']) && !empty($_GET['query'])) {
      $query = $_GET['query'];
    }
    if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {
      $orderby = $_GET['orderby'];
    }
    if (isset($_GET['delayed'])) {
      $delayed = filter_var($_GET['delayed'], FILTER_VALIDATE_BOOLEAN);
    }
    if (isset($_GET['desc'])) {
      $desc = filter_var($_GET['desc'], FILTER_VALIDATE_BOOLEAN);
    }
    $borrowings = $this->borrowingModel->getBorrowings(false, $query, $orderby, $delayed, $desc);


    $data = [
      'card-header' => 'Not returned borrowings :',
      'borrowings' => $borrowings,
      'status' => 'not returned',
    ];
    $this->view('admins/index', $data);
  }

  public function archive()
  {
    $query = null;
    $orderby = 'BorrowingDate';
    $delayed = false;
    $desc = false;
    if (isset($_GET['query']) && !empty($_GET['query'])) {
      $query = $_GET['query'];
    }
    if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {
      $orderby = $_GET['orderby'];
    }
    if (isset($_GET['delayed'])) {
      $delayed = filter_var($_GET['delayed'], FILTER_VALIDATE_BOOLEAN);
    }
    if (isset($_GET['desc'])) {
      $desc = filter_var($_GET['desc'], FILTER_VALIDATE_BOOLEAN);
    }
    $borrowings = $this->borrowingModel->getBorrowings(true, $query, $orderby, $delayed, $desc);
    $data = [
      'card-header' => 'Returned borrowings :',
      'borrowings' => $borrowings,
      'status' => 'returned'
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
  }

  public function confirm()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'sanction' => $_POST['sanction'] ?? false,
        'barcode' => isset($_POST['barcode']) ? trim($_POST['barcode']) : '',
        'idborrowing' => isset($_POST['idborrowing']) ? trim($_POST['idborrowing']) : '',
        'enddate' => isset($_POST['enddate']) ? trim($_POST['enddate']) : '',
        'enddate_err' => '',
        'note' => isset($_POST['note']) ? trim($_POST['note']) : '',
      ];

      if ($data['sanction']) {
        if (empty($data['enddate'])) {
          flash('borrowing', 'End date is required!', 'alert alert-danger');
          $data['enddate_err'] = 'Invalid end date!';
        } elseif (strtotime($data['enddate']) <= strtotime(date("Y/m/d"))) {
          flash('borrowing', 'End date must be greather than current date', 'alert alert-danger');
          $data['enddate_err'] = 'End date must be greather than current date!';
        } elseif (empty($data['barcode'])) {
          flash('borrowing', 'Something wrong!', 'alert alert-danger');
        } else {
          try {
            $this->sanctionModel->add($data['barcode'], $data['enddate'], $data['note']);
          } catch (PDOException $e) {
            flash('borrowing', 'Something wrong!', 'alert alert-danger');
          }
        }
      }

      if (empty($data['idborrowing'])) {

        flash('borrowing', 'Something wrong!', 'alert alert-danger');
      } else {
        try {
          $this->borrowingModel->confirm($data['idborrowing']);
          flash('borrowing', 'Book returned successfully!');
        } catch (PDOException $e) {
          flash('reservation', 'Something wrong!', 'alert alert-danger');
        }
        redirect('borrowings');
      }
    } else {
      $borrowings = $this->borrowingModel->getBorrowings();
      $data['borrowings'] = $borrowings;
      $this->view('admins/index', $data);
    }
  }
}
