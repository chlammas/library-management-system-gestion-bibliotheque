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
    $this->db->query('SELECT * FROM allborrowers WHERE Barcode = :Barcode');
    $this->db->bind(':Barcode', $barCode);

    return $this->db->single();
  }
  public function findBorrowers($query = '', $filterby = null, $orderby = 'Barcode')
  {

    if ($filterby === 'blocked') {
      $sql = "SELECT * FROM blockedborrowers";
    } elseif ($filterby === 'active') {
      $sql = "SELECT * FROM Activeborrowers";
    } else {
      $sql = "SELECT * FROM allborrowers";
    }

    // Get borrowers who match this search query
    $sql .= " WHERE (Barcode LIKE :query or Firstname LIKE :query or Lastname LIKE :query or CIN LIKE :query or program LIKE :query)";
    if ($orderby === 'Firstname' || $orderby === 'Lastname' || $orderby === 'CIN' || $orderby === 'Barcode') {
      $sql .= " ORDER BY " . $orderby;
    }

    $this->db->query($sql);
    $this->db->bind(':query', '%' . $query . '%');

    return $this->db->resultSet();
  }
}
