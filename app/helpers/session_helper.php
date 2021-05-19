<?php

session_start();

// Flash message helper
function flash($name = '', $message = '', $class = 'alert alert-success')
{
  if (!empty($name)) {
    // No message, create it
    if (!empty($message) && empty($_SESSION[$name])) {

      if (!empty($_SESSION[$name . '_class'])) {
        unset($_SESSION[$name . '_class']);
      }
      $_SESSION[$name] = $message;
      $_SESSION[$name . '_class'] = $class;
    }
    // Message exists, display it
    elseif (!empty($_SESSION[$name]) && empty($message)) {
      $class = $_SESSION[$name . '_class'] ?? $class;
      echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name . '_class']);
    }
  }
}

function createUserSession($user, $type = 'borrower')
{
  $unsetType = $type === 'admin' ? 'borrower' : 'admin';
  // To make sure that borrower and admin can't login in the same session
  unset($_SESSION[$unsetType . '_barcode']);
  unset($_SESSION[$unsetType . '_firstname']);
  unset($_SESSION[$unsetType . '_lastname']);

  $_SESSION[$type . '_barcode'] = $user->Barcode;
  $_SESSION[$type . '_firstname'] = $user->Firstname;
  $_SESSION[$type . '_lastname'] = $user->Lastname;
}

function userLogout($type = 'borrower')
{
  unset($_SESSION[$type . '_barcode']);
  unset($_SESSION[$type . '_firstname']);
  unset($_SESSION[$type . '_lastname']);
  redirect('pages/index/' . $type);
}

function isBorrowerLoggedIn()
{
  return isset($_SESSION['borrower_barcode']);
}
function isAdminLoggedIn()
{
  return isset($_SESSION['admin_barcode']);
}

if (isset($_GET['lang'])) {
  if ($_GET['lang'] === 'en' || $_GET['lang'] === 'fr') {
    $_SESSION['lang'] = $_GET['lang'];
  }
} elseif (!isset($_SESSION['lang'])) {
  $_SESSION['lang'] = 'en';
}
