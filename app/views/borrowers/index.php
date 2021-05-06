<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php flash('reservation'); ?>
<!-- borrowed books -->
<?php 
if (!empty($data['borrowing'])) 
  require_once APPROOT . '/views/borrowers/inc/borrowings.inc.php';
?>


<!-- Reserved books -->
<?php 
if (!empty($data['reservation'])) 
require_once APPROOT . '/views/borrowers/inc/reservations.inc.php';
?>

<!-- To search for a book -->
<?php 
require_once APPROOT . '/views/borrowers/inc/books.inc.php';
?>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>