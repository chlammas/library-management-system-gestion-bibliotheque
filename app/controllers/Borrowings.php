<?php

class borrowings extends Controller
{

  private Borrowing $borrowingModel;
  private Reservation $reservationModel;
  private Sanction $sanctionModel;
  private Book $bookModel;
  private $lang;
  public function __construct()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }

    $this->borrowingModel = $this->model('Borrowing');
    $this->reservationModel = $this->model('Reservation');
    $this->sanctionModel = $this->model('Sanction');
    $this->bookModel = $this->model('Book');

    global $language;
    $this->lang = $language;
  }

  public function index()
  {

    $borrowings = $this->getBorrowings($_GET, false);

    $data = [
      'card-header' => $this->lang['not_returned_bgs'],
      'borrowings' => $borrowings,
      'status' => 'not returned',
    ];
    $this->view('admins/index', $data);
  }

  public function archive()
  {
    $borrowings = $this->getBorrowings($_GET, true);

    $data = [
      'card-header' => $this->lang['returned_bgs'],
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
        'card-header' => $this->lang['not_returned_bgs'],
        'status' => 'not returned',
        'referer' => 'borrowings/add'
      ];

      if (strpos($_SERVER["HTTP_REFERER"], 'reservations') !== false) {
        $data['referer'] = 'reservations';
      }

      if (empty($data['barcode'])) {
        $data['barcode_err'] = $this->lang['invalid_br_bcode'];
      }
      if (empty($data['inv'])) {
        $data['inv_err'] = $this->lang['please_inv'];
      }

      // Make sure there is no error
      if (empty($data['barcode_err']) && empty($data['inv_err'])) {
        try {
          $this->borrowingModel->add($data['barcode'], $data['inv']);
          flash('borrowing', $this->lang['book_borrowed']);
          redirect('borrowings');
        } catch (PDOException $e) {
          $expectedError = $this->lang['book_already_borrowed'];
          if (strpos($e->getMessage(), $expectedError) !== false) {
            flash('reservation', $expectedError, 'alert alert-danger');
            $data['inv_err'] = $expectedError;
          } else {
            $expectedError = strpos($e->getMessage(), 'Inv') !== false ? $this->lang['inventory_invalid'] : $this->lang['something_wrong'];

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
        'add_borrowing' => true,
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
          flash('borrowing', $this->lang['end_date_required'], 'alert alert-danger');
          $data['enddate_err'] = $this->lang['invalid_end_date'];
        } elseif (strtotime($data['enddate']) <= strtotime(date("Y/m/d"))) {
          flash('borrowing', $this->lang['end_date_greather_curr_date'], 'alert alert-danger');
          $data['enddate_err'] = $this->lang['end_date_greather_curr_date'];
        } elseif (empty($data['barcode'])) {
          flash('borrowing', $this->lang['something_wrong'], 'alert alert-danger');
        } else {
          try {
            $this->sanctionModel->add($data['barcode'], $data['enddate'], $data['note']);
          } catch (PDOException $e) {
            flash('borrowing', $this->lang['something_wrong'], 'alert alert-danger');
          }
        }
      }

      if (empty($data['idborrowing'])) {

        flash('borrowing', $this->lang['something_wrong'], 'alert alert-danger');
      } else {
        try {
          $this->borrowingModel->confirm($data['idborrowing']);
          flash('borrowing', $this->lang['book_returned']);
        } catch (PDOException $e) {
          flash('reservation', $this->lang['something_wrong'], 'alert alert-danger');
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
