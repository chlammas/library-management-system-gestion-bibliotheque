<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php flash('reservation'); ?>
<!-- borrowed books -->
<?php if (!empty($data['borrowing'])) : ?>

<?php endif ?>

<!-- Reserved books -->
<?php if (!empty($data['reservation'])) : ?>

<?php endif ?>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>