<?php

class Borrower
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function findBorrowerByBarCode($barCode)
  {
    $this->db->query('SELECT * FROM borrower WHERE Barcode = :Barcode');
    $this->db->bind(':Barcode', $barCode);

    return $this->db->single();
  }

}
