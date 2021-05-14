<?php
class Statistics extends Controller
{
  static Borrowing $borrowingModel;
  static Reservation $reservationModel;
  static Book $bookModel;

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
    return count(self::$borrowingModel->getBorrowings(false));
  }
  static function OutOfStockBooksCount()
  {
    require_once '../app/models/Borrowing.php';
    self::$bookModel = new Book;
    return count(self::$bookModel->findBooks(false));
  }
}
