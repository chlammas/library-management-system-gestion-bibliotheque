<?php

class Admins extends Controller
{
  private Admin $adminModel;
  private Reservation $reservationModel;

  public function __construct()
  {
    $this->adminModel = $this->model('Admin');
    $this->reservationModel = $this->model('Reservation');
  }

  public function index()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }

    $this->view('admins/index');
  }

  public function login()
  {
    [$success, $data] = validateLoginRequest($_SERVER['REQUEST_METHOD'], $_POST, 'admin');
    if ($success === true) {

      $loggedInUser = $this->adminModel->findAdminByBarCode($data['barcode']);

      if ($loggedInUser) {
        // Create session
        createUserSession($loggedInUser, 'admin');

        redirect('admins/dashboard');
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
    userLogout('admin');
  }
}
