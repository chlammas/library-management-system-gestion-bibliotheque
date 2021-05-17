<?php
class Pages extends Controller
{


  public function __construct()
  {
  }

  public function index($type = '')
  {
    if (isAdminLoggedIn()) {
      redirect('admins/dashboard');
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
