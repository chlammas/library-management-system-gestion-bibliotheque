<?php

class Admin
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function findAdminByBarCode($barCode)
  {
    $this->db->query('SELECT * FROM administrator WHERE Barcode = :Barcode');
    $this->db->bind(':Barcode', $barCode);

    return $this->db->single();
  }

}
