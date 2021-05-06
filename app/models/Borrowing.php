<?php

class Borrowing
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function findBorrowingByUserCode($barcode, Bool $returned = null)
  {
    $sql = 'SELECT bg.Id, bc.ISBN, Title, Category, Author, bg.Inv, BorrowingDate, DueDate 
    FROM borrower br
    INNER JOIN borrowing bg ON br.Barcode = bg.BorrowerBarcode
    INNER JOIN bookcopy bc ON bg.Inv = bc.INV
    INNER JOIN book b ON bc.ISBN = b.ISBN AND br.Barcode = :Barcode';

    // if null => all borrowings
    // if true => returned borrowings
    // if false => not returned borrowings
    if (!is_null($returned)) {
      $sql .= ' AND IsReturned = ' . var_export($returned, true);
    }

    $this->db->query($sql);
    $this->db->bind(':Barcode', $barcode);
    return $this->db->single();
  }

  public function getAllBorrowings(Bool $returned = null)
  {
    $sql = 'SELECT Firstname, Lastname, CIN, bg.Id, bc.ISBN, Title, Category, Author, bg.Inv, BorrowingDate, DueDate 
    FROM borrower br
    INNER JOIN borrowing bg ON br.Barcode = bg.BorrowerBarcode
    INNER JOIN bookcopy bc ON bg.Inv = bc.INV
    INNER JOIN book b ON bc.ISBN = b.ISBN';

    // if null => all borrowings
    // if true => returned borrowings
    // if false => not returned borrowings
    if (!is_null($returned)) {
      $sql .= ' AND IsReturned = ' . var_export($returned, true);
    }

    $this->db->query($sql);
    return $this->db->resultSet();
  }

  public function add($barcode, $inv)
  {

    $sql = 'INSERT INTO borrowing (BorrowerBarcode, Inv)
     VALUES (:BorrowerBarcode, :Inv)';
    $this->db->query($sql);
    $this->db->bind(':BorrowerBarcode', $barcode);
    $this->db->bind(':Inv', $inv);
    return $this->db->execute();
  }
}
