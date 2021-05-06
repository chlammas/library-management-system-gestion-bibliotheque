<div class="card text-center card-borrower">
    <div class="card-header">
      borrowed books :
    </div>
    <div class="card-body">
      <span class="card-title"><strong>*</strong></span>
      <span class="card-text">Please return books as soon as possible to prevent any block !</span>
    </div>
    <table class="table table-books">
      <thead class="table-light">
        <tr>
          <th class="col hidden">Id</th>
          <th scope="col">ISBN</th>
          <th scope="col">Title</th>
          <th scope="col">Category</th>
          <th scope="col">Author</th>
          <th scope="col">Inv</th>
          <th scope="col">BorrowingDate</th>
          <th scope="col">DueDate</th>
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