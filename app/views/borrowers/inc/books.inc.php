<div class="card text-center card-borrower">
  <div class="card-header">
    Search for a book :
  </div>
  <div class="card-body">
    <form method="POST" class="search-form row g-3 justify-content-center">
      <div class="col-auto">
      </div>
      <div class="col-auto">
        <input type="text" name="query" class="form-control" placeholder="Type here to search...">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary btn-search mb-3">Search now</button>
      </div>
    </form>
    <div class="books-list table-responsive">
      <table class="table table-books">
        <?php if (!empty($data['books'])) : ?>
          <thead class="table-light">
            <tr>
              <th scope="col">ISBN</th>
              <th scope="col">Title</th>
              <th scope="col">Type</th>
              <th scope="col">Category</th>
              <th scope="col">Edition</th>
              <th scope="col">Author</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['books'] as $book) : ?>
              <tr>
                <th scope="row"><?= $book->ISBN ?></th>
                <td><?= $book->Title ?></td>
                <td><?= $book->Type ?></td>
                <td><?= $book->Category ?></td>
                <td><?= $book->Edition ?></td>
                <td><?= $book->Author ?></td>
                <?php if (!empty($data['borrowing'])) : ?>
                  <td title="Please return the borrowed book before reserving new one !"><a href="<?= URLROOT ?>/reservations/add/<?= $book->ISBN ?>" class="btn btn-outline-primary btn-search disabled">Reserve now</a></td>

                <?php elseif (!empty($data['reservation'])) : ?>

                  <td title="You can't make more than one resrvation at the same time!"><a href="<?= URLROOT ?>/reservations/add/<?= $book->ISBN ?>" class="btn btn-outline-primary btn-search disabled">Reserve now</a></td>
                <?php else : ?>
                  <td><a href="<?= URLROOT ?>/reservations/add/<?= $book->ISBN ?>" class="btn btn-outline-primary btn-search ">Reserve now</a></td>
                <?php endif ?>
              </tr>
            <?php endforeach ?>

          </tbody>
        <?php else : ?>
      </table>
      <p><?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? 'There are no results that match your search' : '' ?> </p>
    </div>
  <?php endif ?>
  </div>

</div>