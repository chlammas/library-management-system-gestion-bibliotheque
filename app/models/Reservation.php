<?php

class Reservation
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function findReservationByUserCode($barcode)
  {
    $sql = 'SELECT r.ISBN, Title, Category, Author, Date 
    FROM borrower br
    INNER JOIN reservation r ON br.Barcode = r.BorrowerBarcode
    INNER JOIN book b ON r.ISBN = b.ISBN AND br.Barcode = :Barcode';

    $this->db->query($sql);
    $this->db->bind(':Barcode', $barcode);
    return $this->db->single();
  }

  public function getAllReservations()
  {
    $sql = 'SELECT br.Barcode, Firstname, Lastname, r.ISBN, Title, Category, Author, Cote, Date 
    FROM borrower br
    INNER JOIN reservation r ON br.Barcode = r.BorrowerBarcode
    INNER JOIN book b ON r.ISBN = b.ISBN';
    $this->db->query($sql);

    return $this->db->resultSet();
  }

  public function add($barcode, $ISBN)
  {

    $sql = 'INSERT INTO reservation (BorrowerBarcode, ISBN)
     VALUES (:Barcode, :ISBN)';
    $this->db->query($sql);
    $this->db->bind(':Barcode', $barcode);
    $this->db->bind(':ISBN', $ISBN);
    return $this->db->execute();
  }

  public function delete($barcode)
  {
    $sql = 'DELETE FROM reservation WHERE BorrowerBarcode = :Barcode';

    $this->db->query($sql);
    $this->db->bind(':Barcode', $barcode);
    return $this->db->execute();
  }
}
