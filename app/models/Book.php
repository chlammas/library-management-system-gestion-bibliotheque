<?php

class Book
{

  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function findBooks($query = '', $filterby = null, $orderby = 'ISBN')
  {

    if ($filterby === 'available') {
      $sql = "SELECT * , 'Available' AS 'Status' 
          FROM availablebooks";
    } elseif ($filterby === 'outofstock') {
      $sql = "SELECT * , 'Out of stock' AS 'Status' 
          FROM outofstockbooks";
    } else {
      $sql = "SELECT * FROM allbooks";
    }

    // Get books which match this search query
    $sql .= " WHERE (Title LIKE :query or Category LIKE :query or Author LIKE :query or Type LIKE :query)";
    if ($orderby === 'ISBN' || $orderby === 'Title') {
      $sql .= " ORDER BY " . $orderby;
    }

    $this->db->query($sql);
    $this->db->bind(':query', '%' . $query . '%');

    return $this->db->resultSet();
  }
  public function findCopies($inv = null, $isbn = null, $Available = null)
  {
    $sql = "SELECT *
          FROM bookcopy";

    if (!is_null($inv)) {
      $sql .= " WHERE Inv = :inv";
    } elseif (!is_null($isbn)) {
      $sql .= " WHERE ISBN = :ISBN";
    }

    if ($Available === true) {
      $sql .= " WHERE Inv NOT IN (SELECT Inv FROM borrowing where IsReturned=false)";
    }

    $this->db->query($sql);
    if (!is_null($inv))
      $this->db->bind(':inv', $inv);
    if (!is_null($isbn))
      $this->db->bind(':ISBN', $isbn);

    return $this->db->resultSet();
  }
  public function findAvailableBooks($query, $all = true)
  {
    // Get All books
    $sql = "SELECT * FROM availablebooks WHERE (Title LIKE :query or Category LIKE :query or Author LIKE :query or Type LIKE :query)";

    // Get All books except those reserved or borrowed by the current user
    if (!$all) {
      $sql .= " AND ISBN NOT IN (SELECT ISBN FROM reservation WHERE BorrowerBarcode = :Barcode) 
      AND ISBN NOT IN (SELECT bc.ISBN FROM borrowing b INNER JOIN bookcopy bc ON b.Inv = bc.Inv AND BorrowerBarcode = :Barcode1)";
    }
    $this->db->query($sql);
    $this->db->bind(':query', '%' . $query . '%');
    if (!$all) {
      $this->db->bind(':Barcode', $_SESSION['borrower_barcode']);
      $this->db->bind(':Barcode1', $_SESSION['borrower_barcode']);
    }

    return $this->db->resultSet();
  }

  public function findBookByInv($inv)
  {

    $sql = "SELECT Title, Inv, Author, Rack FROM allbooks a 
            INNER JOIN bookcopy b ON a.ISBN = b.ISBN 
            WHERE Inv = :Inv";

    $this->db->query($sql);
    $this->db->bind(':Inv', $inv);

    return $this->db->single();
  }

  public function findBookByISBN($isbn)
  {

    $sql = "SELECT * FROM book WHERE ISBN = :ISBN";

    $this->db->query($sql);
    $this->db->bind(':ISBN', $isbn);

    return $this->db->single();
  }

  public function add($isbn, $title, $type, $category, $edition, $rack, $author)
  {

    $sql = 'INSERT INTO book
     VALUES (:ISBN, :Title, :Type, :Category, :Edition, :Rack, :Author)';
    $this->db->query($sql);
    $this->db->bind(':ISBN', $isbn);
    $this->db->bind(':Title', $title);
    $this->db->bind(':Type', $type);
    $this->db->bind(':Category', $category);
    $this->db->bind(':Edition', $edition);
    $this->db->bind(':Rack', $rack);
    $this->db->bind(':Author', $author);
    return $this->db->execute();
  }
  public function addcopy($isbn, $inv)
  {

    $sql = 'INSERT INTO bookcopy
     VALUES (:Inv, :ISBN)';
    $this->db->query($sql);
    $this->db->bind(':Inv', $inv);
    $this->db->bind(':ISBN', $isbn);
    return $this->db->execute();
  }
  public function edit($current_isbn, $isbn, $title, $type, $category, $edition, $rack, $author)
  {

    $sql = 'UPDATE book
     SET ISBN=:ISBN, Title=:Title, Type=:Type, Category=:Category, Edition=:Edition, Rack=:Rack, Author=:Author
     WHERE ISBN=:CurrentISBN';
    $this->db->query($sql);
    $this->db->bind(':CurrentISBN', $current_isbn);
    $this->db->bind(':ISBN', $isbn);
    $this->db->bind(':Title', $title);
    $this->db->bind(':Type', $type);
    $this->db->bind(':Category', $category);
    $this->db->bind(':Edition', $edition);
    $this->db->bind(':Rack', $rack);
    $this->db->bind(':Author', $author);
    return $this->db->execute();
  }

  /* statistics */
  public function BorrowedBooks($limit = 10, $order = 'asc')
  {
    if ($order === 'desc')
      $sql = "SELECT * FROM mostborrowedbooks";
    else
      $sql = "SELECT * FROM leastborrowedbooks";

    if (is_integer($limit))
      $sql .= ' LIMIT ' . $limit;
    $this->db->query($sql);
    return $this->db->resultSet();
  }
}
