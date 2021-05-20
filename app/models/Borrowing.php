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
    $sql = 'SELECT bg.Id, bc.ISBN, Title, Category, Author, bg.Inv, BorrowingDate, DueDate, ReturnedDate, IsReturned
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
    if (is_null($returned)) {
      return $this->db->resultSet();
    } else {
      return $this->db->single();
    }
  }

  public function getBorrowings(Bool $returned = null, $query = '', $orderby = 'BorrowingDate', Bool $delayed = false, Bool $desc = false)
  {
    $sql = 'SELECT Barcode, Firstname, Lastname, CIN, bg.Id, bc.ISBN, Title, Category, Author, bg.Inv, BorrowingDate, DueDate, IsReturned, ReturnedDate 
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
    if ($delayed) {
      $sql .= ' AND DueDate < CURRENT_DATE';
    }
    $sql .= ' WHERE (Firstname LIKE :query or Lastname LIKE :query or CIN LIKE :query or Title LIKE :query or Author LIKE :query or Category LIKE :query)';
    $sql .= ' ORDER BY ' . $orderby;
    if ($desc) {
      $sql .= ' DESC';
    }

    $this->db->query($sql);
    $this->db->bind(':query', '%' . $query . '%');

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

  public function confirm($id)
  {

    $sql = 'UPDATE borrowing SET IsReturned = true, ReturnedDate = CURRENT_DATE WHERE Id = :Id';
    $this->db->query($sql);
    $this->db->bind(':Id', $id);
    return $this->db->execute();
  }

  /* statistics */
  public function borrowingsNumber()
  {
    $sql = "SELECT * FROM borrowingsnumber";
 
    $this->db->query($sql);
    return $this->db->resultSet();
  }
}
