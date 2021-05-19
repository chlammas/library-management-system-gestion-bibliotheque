<div class="card text-center card-borrower">
  <div class="card-header">
    <?= $language['books_header'] ?>
  </div>
  <div class="card-body">
    <form method="POST" class="search-form row g-3 justify-content-center">
      <div class="col-auto">
        <label><?= $language['filter_by'] ?> :</label>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="filterby" id="allbooks" checked>
          <label class="form-check-label small text-muted" for="allbooks">
          <?= $language['all_books'] ?>
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="filterby" id="outofstock">
          <label class="form-check-label small text-muted" for="outofstock">
          <?= $language['out_of_stock_books'] ?>
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="filterby" id="available">

          <label class="form-check-label small text-muted" for="available">
          <?= $language['available_books'] ?>
          </label>
        </div>
      </div>
      <div class="col-auto">
        <label>Order by:</label>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="ISBN" checked>
          <label class="form-check-label small text-muted" for="ISBN">
          <?= $language['table_isbn'] ?>
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="Title">

          <label class="form-check-label small text-muted" for="Title">
          <?= $language['table_title'] ?>
          </label>
        </div>
      </div>
      <hr>
      <div class="col-auto">
        <input type="text" name="query" class="form-control" placeholder="<?= $language['search_placeholder'] ?>">
      </div>
      <!-- <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary btn-search mb-3">Search now</button>
      </div> -->
    </form>
    <hr>

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
              <th scope="col"><?= $language['table_rack'] ?></th>
              <th scope="col"><?= $language['table_author'] ?></th>
              <th scope="col"><?= $language['table_status'] ?></th>
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
                <td><?= $book->Rack ?></td>
                <td><?= $book->Author ?></td>
                <td><?= $book->Status ?></td>

                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="<?= URLROOT ?>/books/addcopy/<?= $book->ISBN ?>" title="Add new copies" class="btn btn-outline-primary btn-search "><i class="fas fa-plus"></i></a>
                    <a href="<?= URLROOT ?>/books/edit/<?= $book->ISBN ?>" title="Add new copies" class="btn btn-outline-primary btn-search "><i class="far fa-edit"></i></i></a>
                  </div>
                </td>

              </tr>
            <?php endforeach ?>

          </tbody>
        <?php else : ?>
      </table>
      <tr>
        <td><?= $language['search_no_result'] ?></td>
      </tr>
    </div>
  <?php endif ?>
  </div>

</div>

<script>
  // AJAX To filter and Search For a Book
  const queryBox = document.querySelector('.search-form input[name="query"]');
  const orderbyInputs = document.querySelectorAll('input[name="orderby"]');
  const filterbyInputs = document.querySelectorAll('input[name="filterby"]');
  let url = "<?= URLROOT ?>" + '/books';
  queryBox.addEventListener('keyup', function(event) {
    makeRequest(url, ...getCurrentValues());
  });
  filterbyInputs.forEach(input => {
    input.addEventListener('change', function(event) {
      makeRequest(url, ...getCurrentValues());
    });
  })
  orderbyInputs.forEach(input => {
    input.addEventListener('change', function(event) {
      console.log(getCurrentValues())
      makeRequest(url, ...getCurrentValues());
    });
  })

  function getCurrentValues() {
    const orderby = document.querySelector('input[name="orderby"]:checked');
    const filterby = document.querySelector('input[name="filterby"]:checked');
    const queryBox = document.querySelector('.search-form input[name="query"]');
    return [queryBox.value, filterby.id, orderby.id];
  }


  let httpRequest = new XMLHttpRequest();

  function makeRequest(url, query, filterby, orderby) {
    httpRequest.onreadystatechange = changeContent;
    url += `?query=${encodeURIComponent(query)}&filterby=${encodeURIComponent(filterby)}&orderby=${encodeURIComponent(orderby)}`;
    console.log(url)
    httpRequest.open('GET', url);
    httpRequest.send();
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