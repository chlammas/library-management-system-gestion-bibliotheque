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

  // public function login()
  // {
  //   if (isAdminLoggedIn()) {
  //     redirect('admins');
  //   }
  //   if (isBorrowerLoggedIn()) {
  //     redirect('borrowers');
  //   }
  //   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['barcode'])) {
  //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  //     $data = [
  //       'barcode' => trim($_POST['barcode']),
  //       'barcode_err' => ''
  //     ];

  //     if (empty($data['barcode'])) {
  //       $data['barcode_err'] = 'Please scan your barcode';
  //     }
  //     // Make sure there is no error
  //     if (empty($data['barcode_err'])) {
  //       $response = json_decode(file_get_contents(URLROOT . '/borrowers/login/' . $data['barcode'], true));

  //       if ($response->success) {
  //         redirect('borrowers');
  //       } else {
  //         $response = json_decode(file_get_contents(URLROOT . '/admins/login/' . $data['barcode'], true));
  //         if ($response->success) {
  //           redirect('admins');
  //         } else {
  //           $data['barcode_err'] = 'Account not found!';
  //           $this->view('pages/index', $data);
  //         }
  //       }
  //     } else {
  //       // Load view with errors
  //       $this->view('pages/index', $data);
  //     }
  //   } else {
  //     redirect('');
  //   }
  //   // header('HTTP/1.1 307 Temporary Redirect');
  //   // $url = 'Location: ' . URLROOT . '/borrowers/login';
  //   // $res = header($url);
  //   // echo $res;
  // }

  public function about()
  {
    $data = ['title' => 'About us'];
    $this->view('pages/about', $data);
  }
}
