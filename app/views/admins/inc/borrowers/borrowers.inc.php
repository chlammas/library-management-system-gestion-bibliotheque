<div class="card text-center card-borrower">
  <div class="card-header">
    Search for a borrower :
  </div>
  <div class="card-body">
    <form method="POST" class="search-form row g-3 justify-content-center">
      <div class="col-auto">
        <label>Filter by:</label>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="filterby" id="allborrowers" checked>
          <label class="form-check-label small text-muted" for="allborrowers">
            All borrowers
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="filterby" id="active">
          <label class="form-check-label small text-muted" for="active">
            Active borrowers
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="filterby" id="blocked">

          <label class="form-check-label small text-muted" for="blocked">
            Blocked borrowers
          </label>
        </div>
      </div>
      <div class="col-auto">
        <label>Order by:</label>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="Barcode" checked>
          <label class="form-check-label small text-muted" for="Barcode">
            Barcode
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="CIN" checked>
          <label class="form-check-label small text-muted" for="CIN">
            CIN
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="Firstname" checked>
          <label class="form-check-label small text-muted" for="Firstname">
            Firstname
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="Lastname">

          <label class="form-check-label small text-muted" for="Lastname">
            Lastname
          </label>
        </div>
      </div>
      <hr>
      <div class="col-auto">
        <input type="text" name="query" class="form-control" placeholder="Type here to search...">
      </div>
      <!-- <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary btn-search mb-3">Search now</button>
      </div> -->
    </form>
    <hr>

    <div class="borrowers-list table-responsive">
      <table class="table table-borrowers">
        <?php if (!empty($data['borrowers'])) : ?>
          <thead class="table-light">
            <tr>
              <th scope="col">Barcode</th>
              <th scope="col">CIN</th>
              <th scope="col">Firstname</th>
              <th scope="col">Lastname</th>
              <th scope="col">Program</th>
              <th scope="col">Status</th>
              <th scope="col">Borrowings</th>
              <th scope="col">Sanctions</th>
              <th scope="col">Details</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['borrowers'] as $borrower) : ?>
              <tr>
                <td><?= $borrower->Barcode ?></td>
                <td><?= $borrower->CIN ?></td>
                <th scope="row"><?= $borrower->Firstname ?></th>
                <th scope="row"><?= $borrower->Lastname ?></th>
                <td><?= $borrower->Program ?></td>
                <td><?= $borrower->Status ?></td>
                <td><?= $borrower->Borrowings ?></td>
                <td><?= $borrower->Sanctions ?></td>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="<?= URLROOT ?>/borrowers/detail/<?= $borrower->Barcode ?>" title="See more details" class="btn btn-outline-primary btn-search ">More...<i class="fas fa-angle-double-right"></i></a>
                  </div>
                </td>

              </tr>
            <?php endforeach ?>

          </tbody>
        <?php else : ?>
      </table>
      <tr>
        <td><?= 'There is no result that match your search' ?> </td>
      </tr>
    </div>
  <?php endif ?>
  </div>

</div>

<script>
  // AJAX To filter and Search For a Borrower
  const queryBox = document.querySelector('.search-form input[name="query"]');
  const orderbyInputs = document.querySelectorAll('input[name="orderby"]');
  const filterbyInputs = document.querySelectorAll('input[name="filterby"]');
    let url = "<?= URLROOT ?>" + '/borrowers/all';
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
        const borrowersList = document.querySelector('.borrowers-list');
        borrowersList.innerHTML = doc.querySelector('.borrowers-list').innerHTML;
      } else {
        alert('There was a problem with the request.');
      }
    }
  }
</script>