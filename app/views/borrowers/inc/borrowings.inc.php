<div class="card text-center card-borrower">
  <div class="card-header">
    <?= $language['borrowing_header'] ?>
  </div>
  <div class="card-body">
    <span class="card-title"><strong>*</strong></span>
    <span class="card-text"><?= $language['borrowing_msg'] ?></span>
  </div>
  <table class="table table-books">
    <thead class="table-light">
      <tr>
        <th class="col hidden"><?= $language['table_id'] ?></th>
        <th scope="col"><?= $language['table_isbn'] ?></th>
        <th scope="col"><?= $language['table_title'] ?></th>
        <th scope="col"><?= $language['table_category'] ?></th>
        <th scope="col"><?= $language['table_author'] ?></th>
        <th scope="col"><?= $language['table_inv'] ?></th>
        <th scope="col"><?= $language['table_borrowing_date'] ?></th>
        <th scope="col"><?= $language['table_due_date'] ?></th>
      </tr>
    </thead>
    <tbody>
      <tr class="clickable">
        <th class="hidden"><?= $data['borrowing']->Id ?></th>
        <th scope="row"><?= $data['borrowing']->ISBN ?></th>
        <td><?= $data['borrowing']->Title ?></td>
        <td><?= $data['borrowing']->Category ?></td>
        <td><?= $data['borrowing']->Author ?></td>
        <td><?= $data['borrowing']->Inv ?></td>
        <td class="borrowing-date"><span><?= $data['borrowing']->BorrowingDate ?></span></td>
        <td class="due-date"><span><?= $data['borrowing']->DueDate ?></span></td>
      </tr>

    </tbody>
  </table>

</div>