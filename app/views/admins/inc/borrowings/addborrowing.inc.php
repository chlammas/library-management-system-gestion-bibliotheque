<style>
  .btn-outline-success {
    color: #198754;
    border-color: #198754;
  }

  .btn-outline-success:hover {
    color: #fff;
    background-color: #198754;
    border-color: #198754;
  }
</style>
<div class="card-group">
  <div class="card text-center">
    <div class="card-header">
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <form class="row g-3 search-form" method="POST" action="<?= URLROOT ?>/borrowers/findBorrowerByBarCode">
        <div class="col-auto">
          <input type="text" name="code" class="form-control-plaintext col-sm-6" placeholder="<?= $language['borrowings_code_placeholder'] ?>">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-outline-primary mb-3"><?= $language['btn_add'] ?></button>
        </div>
      </form>
    </div>
    <div class="card-footer text-muted">
    </div>
  </div>
</div>
<div class="card-group">
  <div class="card border-success mb-3 borrower-card" style="max-width: 540px;">
    <!-- Borrrower info will be here -->
  </div>
  <div class="card border-success mb-3 book-card" style="max-width: 540px;">
    <!-- Book info will be here -->
  </div>
</div>
<div class="card-group">
  <div class="card text-center">
    <div class="card-header">
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <p class="card-text"></p>
      <form class="row g-3 confirm-form" method="POST" action="<?= URLROOT ?>/borrowings/add">
        <div class="col-auto">
          <input type="hidden" name="barcode">
        </div>
        <div class="col-auto">
          <input type="hidden" name="inv">
        </div>
        <div class="col-auto">
          <label>
          <?= $language['borrowings_confirm_msg'] ?>
          </label>
          <button type="submit" class="btn btn-outline-success"><?= $language['btn_confirm'] ?></button>
        </div>
      </form>
    </div>
    <div class="card-footer text-muted">
    </div>
  </div>
</div>

<script>
  const searchForm = document.querySelector('.search-form');
  if (searchForm) {
    searchForm.addEventListener('submit', function(event) {
      event.preventDefault();

      getBorrowerOrBook(searchForm.code.value);
    });
  }

  function getBorrowerOrBook(code) {
    let url = '<?= URLROOT ?>/borrowers/findBorrowerByBarCode'
    if (code) {
      makeRequest(url, code);
    }
  }

  let httpRequest = new XMLHttpRequest();

  function makeRequest(url, code = '', to = 'borrower') {
    httpRequest.onreadystatechange = () => {
      status = addCard(to, code)
      if (status == 404) {
        if (to == 'borrower') {
          url = '<?= URLROOT ?>/books/findBookByInv'
          makeRequest(url, code, to = 'book');
        } else {
          alert('Barcode or Inv is Invalid')
        }
      }
    };
    httpRequest.open('POST', url);
    httpRequest.setRequestHeader(
      'Content-Type',
      'application/x-www-form-urlencoded'
    );
    httpRequest.send('code=' + encodeURIComponent(code));
  }

  function addCard(to, code) {
    const cardBorrower = document.querySelector('.borrower-card');
    const cardBook = document.querySelector('.book-card');
    const confirmForm = document.querySelector('.confirm-form');
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      if (httpRequest.status === 200) {
        var response = httpRequest.responseText;
        const parser = new DOMParser();

        // Parse the text
        const doc = parser.parseFromString(response, 'text/html');
        if (to === 'book') {
          cardBook.outerHTML = httpRequest.responseText
          confirmForm.inv.value = searchForm.code.value
          searchForm.code.value = ""
        } else {
          confirmForm.barcode.value = searchForm.code.value
          cardBorrower.outerHTML = httpRequest.responseText
          searchForm.code.value = ""
        }


      }
      return httpRequest.status;

    }
  }
</script>