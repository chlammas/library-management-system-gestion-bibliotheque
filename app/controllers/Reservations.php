<?php
class Reservations extends Controller
{

  private Reservation $reservationModel;
  private Borrowing $borrowingModel;

  public function __construct()
  {
    if (!isAdminLoggedIn()) {
      redirect('pages/index/admin');
    }

    $this->reservationModel = $this->model('Reservation');
    $this->borrowingModel = $this->model('Borrowing');
  }

  public function index()
  {
    $reservations = $this->reservationModel->getAllReservations();
    $data = [
      'reservations' => $reservations
    ];
    $this->view('admins/index', $data);
  }

  public function add($ISBN)
  {
    $barcode = $_SESSION['borrower_barcode'];
    $reservation = $this->reservationModel->findReservationByUserCode($barcode);
    try {
      if ($reservation) {
        flash('reservation', 'You can\'t make more than one resrvation at the same time!', 'alert alert-danger');
      } elseif ($this->reservationModel->add($barcode, trim($ISBN))) {
        flash('reservation', 'Book reserved successfully!');
      } else {
        flash('reservation', 'Something wrong!', 'alert alert-danger');
      }
    } catch (PDOException $e) {
      $expectedError = 'You are blocked ! Please contact the administrator!';
      if (strpos($e->getMessage(), $expectedError) !== false) {
        flash('reservation', $expectedError, 'alert alert-danger');
      } else {
        flash('reservation', 'Something wrong!', 'alert alert-danger');
      }
    }
    redirect('borrwings');
  }

  public function confirm()
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
        'status' => 'not returned'
      ];

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
          redirect('reservations');
        }
      } else {
        $err_msg = '<ul>';
        $err_msg .= $data['barcode_err'] ?  '<li>' . $data['barcode_err'] . '</li>' : '';
        $err_msg .= $data['inv_err'] ?  '<li>' . $data['inv_err'] . '</li>' : '';
        $err_msg .= '</ul>';

        flash('reservation', $err_msg, 'alert alert-danger');
        redirect('reservations');
      }
    } else {
      redirect('reservations');
    }
  }

  public function cancel($barcode)
  {
    if ($this->reservationModel->delete($barcode)) {
      flash('reservation', 'Reservation canceled!', 'alert alert-info');
    } else {
      flash('reservation', 'Something wrong!', 'alert alert-danger');
    }
    redirect('reservations');
  }
}
