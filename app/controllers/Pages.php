<?php
class Pages extends Controller
{


  public function __construct()
  {
  }

  public function index($type = 'borrower')
  {
    if (isAdminLoggedIn()) {
      redirect('admins');
    }
    if (isBorrowerLoggedIn()) {
      redirect('borrowers');
    }

    $data = [
      'barcode' => '',
      'barcode_err' => '',
      'type' => $type,
    ];

    $this->view('pages/index', $data);
  }

  public function about()
  {
    $data = ['title' => 'About us'];
    $this->view('pages/about', $data);
  }
}
