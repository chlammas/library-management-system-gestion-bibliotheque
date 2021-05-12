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

    $borrowings = $this->getBorrowings($_GET, false);

    $data = [
      'card-header' => 'Not returned borrowings :',
      'borrowings' => $borrowings,
      'status' => 'not returned',
    ];
    $this->view('admins/index', $data);
  }

  public function archive()
  {
    $borrowings = $this->getBorrowings($_GET, true);

    $data = [
      'card-header' => 'Returned borrowings :',
      'borrowings' => $borrowings,
      'status' => 'returned'
    ];
    $this->view('admins/index', $data);
  }
  private function getBorrowings($request, Bool $returned = null)
  {
    $query = null;
    $orderby = 'BorrowingDate';
    $delayed = false;
    $desc = false;
    if (isset($request['query']) && !empty($request['query'])) {
      $query = $request['query'];
    }
    if (isset($request['orderby']) && !empty($request['orderby'])) {
      $orderby = $request['orderby'];
    }
    if (isset($request['delayed'])) {
      $delayed = filter_var($request['delayed'], FILTER_VALIDATE_BOOLEAN);
    }
    if (isset($request['desc'])) {
      $desc = filter_var($request['desc'], FILTER_VALIDATE_BOOLEAN);
    }
    return $this->borrowingModel->getBorrowings($returned, $query, $orderby, $delayed, $desc);
  }


  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'barcode' => isset($_POST['barcode']) ? trim($_POST['barcode']) : '',
        'barcode_err' => '',
        'inv' => isset($_POST['inv']) ? trim($_POST['inv']) : '',
        'inv_err' => '',
        'fullname' => isset($_POST['fullname']) ? trim($_POST['fullname']) : '',
        'card-header' => 'Not returned borrowings :',
        'status' => 'not returned',
        'referer' => 'borrowings'
      ];

      if (strpos($_SERVER["HTTP_REFERER"], 'reservations') !== false) {
        $data['referer'] = 'reservations';
      }

      if (empty($data['barcode'])) {
        $data['barcode_err'] = 'Invalid borrower barcode';
      }
      if (empty($data['inv'])) {
        $data['inv_err'] = 'Please scan book inventory number';
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
            $expectedError = strpos($e->getMessage(), 'Inv') !== false ? 'Book Inventory is invalid!' : 'Something wrong!';

            flash('reservation', $expectedError, 'alert alert-danger');
          }
          redirect($data['referer']);
        }
      } else {
        $err_msg = '<ul>';
        $err_msg .= $data['barcode_err'] ?  '<li>' . $data['barcode_err'] . '</li>' : '';
        $err_msg .= $data['inv_err'] ?  '<li>' . $data['inv_err'] . '</li>' : '';
        $err_msg .= '</ul>';

        flash('reservation', $err_msg, 'alert alert-danger');
        redirect($data['referer']);
      }
    } else {
      $data = [
        'add' => true,
        'sanctions' => '',
        'borrower' => '',
        'bookcopy' => '',
      ];
      $this->view('admins/index', $data);
    }
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
