<?php
class Statistics extends Controller
{
  static Borrowing $borrowingModel;
  static Reservation $reservationModel;

  static function reservationsCount()
  {
    require_once '../app/models/Reservation.php';
    
    self::$reservationModel = new Reservation;
    return count(self::$reservationModel->getAllReservations());
  }
  static function NotReturnedBorrowingsCount()
  {
    require_once '../app/models/Borrowing.php';
    self::$borrowingModel = new Borrowing;
    return count(self::$borrowingModel->getAllBorrowings(false));
  }
}
