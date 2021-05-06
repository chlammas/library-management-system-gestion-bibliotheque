<?php

class Book
{

  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function findAvailableBooks($query, $all=true)
  {
    // Get All books
    $sql = "SELECT * FROM availablebooks WHERE (Title LIKE :query or Category LIKE :query or Author LIKE :query or Type LIKE :query)";

    // Get All books except those reserved or borrowed by the current user
    if (!$all) {
      $sql .= " AND ISBN NOT IN (SELECT ISBN FROM reservation WHERE BorrowerBarcode = :Barcode) 
      AND ISBN NOT IN (SELECT bc.ISBN FROM borrowing b INNER JOIN bookcopy bc ON b.Inv = bc.Inv AND BorrowerBarcode = :Barcode1)";
    }
    $this->db->query($sql);
    $this->db->bind(':query', '%'.$query.'%');
    $this->db->bind(':Barcode', $_SESSION['borrower_barcode']);
    $this->db->bind(':Barcode1', $_SESSION['borrower_barcode']);

    return $this->db->resultSet();
  }

}
