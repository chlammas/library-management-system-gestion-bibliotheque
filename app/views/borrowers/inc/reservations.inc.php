<div class="card text-center card-borrower">
    <div class="card-header">
    <?= $language['reservation_header'] ?>
    </div>
    <div class="card-body">
      <span class="card-title"><strong>*</strong></span>
      <span class="card-text"><?= $language['reservation_msg'] ?></span>
    </div>
    <div class="table-responsive">
      <table class="table table-books ">
        <thead class="table-light">
          <tr>
            <th scope="col"><?= $language['table_isbn'] ?></th>
            <th scope="col"><?= $language['table_title'] ?></th>
            <th scope="col"><?= $language['table_category'] ?></th>
            <th scope="col"><?= $language['table_author'] ?></th>
            <th scope="col"><?= $language['table_date'] ?></th>
            <th scope="col"><?= $language['table_action'] ?></th>
          </tr>
        </thead>
        <tbody>
          <tr class="clickable">
            <th scope="row"><?= $data['reservation']->ISBN ?></th>
            <td><?= $data['reservation']->Title ?></td>
            <td><?= $data['reservation']->Category ?></td>
            <td><?= $data['reservation']->Author ?></td>
            <td><?= $data['reservation']->Date ?></td>
            <td><a href="<?php echo URLROOT ?>/reservations/cancel/<?php echo $_SESSION['borrower_barcode'] ?>"><?= $language['btn_cancel'] ?></a></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>