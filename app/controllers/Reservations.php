<?php
class Reservations extends Controller
{

  private Reservation $reservationModel;

  public function __construct()
  {
    if (!isAdminLoggedIn()) {
      redirect('pages/index/admin');
    }

    $this->reservationModel = $this->model('Reservation');
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
      } elseif ($this->reservationModel->add($barcode, $ISBN)) {
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
