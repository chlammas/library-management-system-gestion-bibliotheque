<?php

class Sanction
{

  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function findSanctionsByUserCode($barcode, $applied=true)
  {
    // Get All user sanctions
    $sql = "SELECT Id, BorrowerBarcode, Firstname, Lastname, EndDate, DATEDIFF(EndDate, CURRENT_DATE) as Remaining, Note  FROM sanction INNER JOIN borrower ON Barcode = BorrowerBarcode WHERE BorrowerBarcode = :Barcode";

    // Get just still applied sanction
    if ($applied) {
      $sql .= " AND EndDate > CURRENT_DATE";
    }

    $sql .= " ORDER BY EndDate DESC";

    $this->db->query($sql);
    $this->db->bind(':Barcode', $barcode);

    return $this->db->resultSet();
  }
  public function add($barcode, $endDate, $note=null)
  {
    $sql = 'INSERT INTO sanction (BorrowerBarcode, EndDate, Note)
     VALUES (:BorrowerBarcode, :EndDate, :Note)';
    $this->db->query($sql);
    $this->db->bind(':BorrowerBarcode', $barcode);
    $this->db->bind(':EndDate', $endDate);
    $this->db->bind(':Note', $note);
    return $this->db->execute();
  }
}
