<div class="card text-center card-borrower">
  <div class="card-header">
    <?= $language['books_header'] ?>
  </div>
  <div class="card-body">
    <form method="POST" class="search-form row g-3 justify-content-center">
      <div class="col-auto">
      </div>
      <div class="col-auto">
        <input type="text" name="query" class="form-control" placeholder="<?= $language['search_placeholder'] ?>">
      </div>

    </form>
    <div class="books-list table-responsive">
      <table class="table table-books">
        <?php if (!empty($data['books'])) : ?>
          <thead class="table-light">
            <tr>
              <th scope="col"><?= $language['table_isbn'] ?></th>
              <th scope="col"><?= $language['table_title'] ?></th>
              <th scope="col"><?= $language['table_type'] ?></th>
              <th scope="col"><?= $language['table_category'] ?></th>
              <th scope="col"><?= $language['table_edition'] ?></th>
              <th scope="col"><?= $language['table_author'] ?></th>
              <th scope="col"><?= $language['table_action'] ?></th>
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
                  <td title="Please return the borrowed book before reserving new one !"><a href="<?= URLROOT ?>/reservations/add/<?= $book->ISBN ?>" class="btn btn-outline-primary btn-search disabled"><?= $language['btn_reserve'] ?></a></td>

                <?php elseif (!empty($data['reservation'])) : ?>

                  <td title="You can't make more than one resrvation at the same time!"><a href="<?= URLROOT ?>/reservations/add/<?= $book->ISBN ?>" class="btn btn-outline-primary btn-search disabled"><?= $language['btn_reserve'] ?></a></td>
                <?php else : ?>
                  <td><a href="<?= URLROOT ?>/reservations/add/<?= $book->ISBN ?>" class="btn btn-outline-primary btn-search "><?= $language['btn_reserve'] ?></a></td>
                <?php endif ?>
              </tr>
            <?php endforeach ?>

          </tbody>
        <?php else : ?>
      </table>
      <tr>
        <td><?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $language['search_no_result'] : '' ?> </td>
      </tr>
    </div>
  <?php endif ?>
  </div>

</div>

<script>
  // AJAX To Search For a Book
  const searchForm = document.querySelector('.search-form');
  const queryBox = document.querySelector('.search-form input[name="query"]');
  if (queryBox) {
    queryBox.addEventListener('keyup', function(event) {
      makeRequest('borrowers', queryBox.value);
    });
  }

  let httpRequest = new XMLHttpRequest();

  function makeRequest(url, query) {
    httpRequest.onreadystatechange = changeContent;
    httpRequest.open('POST', url);
    httpRequest.setRequestHeader(
      'Content-Type',
      'application/x-www-form-urlencoded'
    );
    httpRequest.send('query=' + encodeURIComponent(query));
  }

  function changeContent() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      if (httpRequest.status === 200) {
        var response = httpRequest.responseText;
        const parser = new DOMParser();

        // Parse the text
        const doc = parser.parseFromString(response, 'text/html');
        const BooksList = document.querySelector('.books-list');
        BooksList.innerHTML = doc.querySelector('.books-list').innerHTML;
      } else {
        alert('There was a problem with the request.');
      }
    }
  }
</script>