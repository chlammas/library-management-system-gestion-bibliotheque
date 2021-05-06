<?php

function validateLoginRequest($method, $request, $type = 'borrower')
{
  if ($method === 'POST' && isset($request['barcode'])) {
    $request = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
      'barcode' => trim($request['barcode']),
      'barcode_err' => '',
      'type' => $type,
    ];

    if (empty($data['barcode'])) {
      $data['barcode_err'] = 'Please scan your barcode';
    }
    // Make sure there is no error
    if (empty($data['barcode_err'])) {
      return [true, $data];
    } else {
      // Load view with errors
      return [false, $data];
    }
  } else {
    redirect($type === 'admin' ? 'pages/index/admin' : 'pages');
  }
}
