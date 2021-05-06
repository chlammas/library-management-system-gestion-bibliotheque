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
<?php if (!empty($data['sanction'])) : ?>

  <div class="alert alert-danger" role="alert">
    <strong>You are blocked!</strong> <br> You can't borrow any book until <i class="alert-link"><?=$data['sanction']->EndDate?></i>.<br> Feel free to contact an administrator if you think that's happened by mistake.
  </div>



<?php else :
  require_once APPROOT . '/views/borrowers/inc/books.inc.php';
endif
?>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>