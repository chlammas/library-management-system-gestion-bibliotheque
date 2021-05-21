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

    global $language;
    $this->lang = $language;
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
        flash('reservation', $this->lang['reservation_max'], 'alert alert-danger');
      } elseif ($this->reservationModel->add($barcode, trim($ISBN))) {
        flash('reservation', $this->lang['book_reserved']);
      } else {
        flash('reservation', $this->lang['something_wrong'], 'alert alert-danger');
      }
    } catch (PDOException $e) {
      $expectedError = $this->lang['you_are_blocked'];
      if (strpos($e->getMessage(), $expectedError) !== false) {
        flash('reservation', $expectedError, 'alert alert-danger');
      } else {
        flash('reservation', $this->lang['something_wrong'], 'alert alert-danger');
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
        'card-header' => $this->lang['not_returned_bgs'],
        'status' => 'not returned'
      ];

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
      flash('reservation', $this->lang['reservation_canceled'], 'alert alert-info');
    } else {
      flash('reservation', $this->lang['something_wrong'], 'alert alert-danger');
    }
    redirect('reservations');
  }
}
