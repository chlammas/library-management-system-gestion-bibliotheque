<?php
class Statistics extends Controller
{
  static Borrowing $borrowingModel;
  static Reservation $reservationModel;
  static Book $bookModel;

  static function booksCount()
  {
    require_once '../app/models/Book.php';
    self::$bookModel = new Book;
    return count(self::$bookModel->findBooks());
  }
  static function CopiesCount()
  {
    require_once '../app/models/Book.php';
    self::$bookModel = new Book;
    return count(self::$bookModel->findCopies());
  }
  static function BorrowedCopiesCount()
  {
    require_once '../app/models/Borrowing.php';
    self::$borrowingModel = new Borrowing;
    return count(self::$borrowingModel->getBorrowings(false));
  }
  static function ReservationsCount()
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
  static function AvailableCopiesCount()
  {
    require_once '../app/models/Book.php';
    self::$bookModel = new Book;
    return count(self::$bookModel->findCopies(null, null, true));
  }
  static function OutOfStockBooksCount()
  {
    require_once '../app/models/Book.php';
    self::$bookModel = new Book;
    return count(self::$bookModel->findBooks('', 'outofstock'));
  }
  static function BorrowedBooks($limit = 10, $order='desc')
  {
    require_once '../app/models/Book.php';
    self::$bookModel = new Book;
    return self::$bookModel->BorrowedBooks($limit, $order);
  }
  static function DelayedBorrowings()
  {
    require_once '../app/models/Book.php';
    self::$borrowingModel = new Borrowing;
    return self::$borrowingModel->getBorrowings(false, '', 'BorrowingDate' , true);
  }

  static function BorrowingsNumberPerDate()
  {
    require_once '../app/models/Borrowing.php';
    self::$borrowingModel = new Borrowing;
    return self::$borrowingModel->borrowingsNumber();
  }
}
