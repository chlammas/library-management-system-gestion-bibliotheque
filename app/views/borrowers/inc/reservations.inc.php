<div class="card text-center card-borrower">
    <div class="card-header">
      Reserved books :
    </div>
    <div class="card-body">
      <span class="card-title"><strong>*</strong></span>
      <span class="card-text">You can not make more than one reservation at the same time</span>
    </div>
    <div class="table-responsive">
      <table class="table table-books ">
        <thead class="table-light">
          <tr>
            <th scope="col">ISBN</th>
            <th scope="col">Title</th>
            <th scope="col">Category</th>
            <th scope="col">Author</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr class="clickable">
            <th scope="row"><?= $data['reservation']->ISBN ?></th>
            <td><?= $data['reservation']->Title ?></td>
            <td><?= $data['reservation']->Category ?></td>
            <td><?= $data['reservation']->Author ?></td>
            <td><?= $data['reservation']->Date ?></td>
            <td><a href="<?php echo URLROOT ?>/reservations/cancel/<?php echo $_SESSION['borrower_barcode'] ?>">Cancel</a></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>