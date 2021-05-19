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

  .card-reservation {
    margin-top: 25px;
  }
</style>

<!-- List of Borrowings with search box-->
<div class="card text-center card-borrower">
  <div class="card-header">
    <?= $data['card-header'] ?>
  </div>
  <div class="card-body">
    <form method="GET" class="search-form row g-3 justify-content-center">
      <?php if ($data['status'] === 'not returned') : ?>
        <div class="col-auto">
          <label><?= $language['filter_by'] ?> :</label>
        </div>
        <div class="col-auto">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="DelayedBorrowings">
            <label class="form-check-label small text-muted" for="DelayedBorrowings">
              <?= $language['delayed_borrowings'] ?>
            </label>
          </div>
        </div>
      <?php endif ?>
      <div class="col-auto">
        <label><?= $language['order_by'] ?> :</label>
      </div>
      <?php if ($data['status'] === 'returned') : ?>
        <div class="col-auto">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="orderby" id="ReturnedDate">
            <label class="form-check-label small text-muted" for="ReturnedDate">
              <?= $language['table_returned_date'] ?>
            </label>
          </div>
        </div>
      <?php endif ?>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="BorrowingDate" checked>
          <label class="form-check-label small text-muted" for="BorrowingDate">
            <?= $language['table_borrowing_date'] ?>
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="orderby" id="DueDate">

          <label class="form-check-label small text-muted" for="DueDate">
            <?= $language['table_due_date'] ?>
          </label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="Desc">
          <label class="form-check-label small text-muted" for="Desc">
            <?= $language['desc'] ?>
          </label>
        </div>
      </div>
      <hr>
      <div class="col-auto">
        <input type="text" name="query" class="form-control" placeholder="<?= $language['search_placeholder'] ?>">
      </div>
    </form>
    <hr>
    <div class="table-responsive">
      <table class="table table-borrowings">
        <?php if (!empty($data['borrowings'])) : ?>
          <thead class="table-light">
            <tr>
              <th class="col hidden"><?= $language['table_id'] ?></th>
              <th scope="col"><?= $language['table_cin'] ?></th>
              <th scope="col"><?= $language['table_firstname'] ?></th>
              <th scope="col"><?= $language['table_lastname'] ?></th>
              <th scope="col"><?= $language['table_title'] ?></th>
              <th scope="col"><?= $language['table_category'] ?></th>
              <th scope="col"><?= $language['table_author'] ?></th>
              <th scope="col"><?= $language['table_inv'] ?></th>
              <th scope="col"><?= $language['table_borrowing_date'] ?></th>
              <th scope="col"><?= $language['table_due_date'] ?></th>
              <?php if ($data['status'] === 'returned') : ?>
                <th scope="col"><?= $language['table_returned_date'] ?></th>
              <?php else : ?>
                <th scope="col"><?= $language['table_action'] ?></th>
              <?php endif ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['borrowings'] as $borrowing) : ?>
              <tr class="clickable">
                <th class="hidden"><?= $borrowing->Barcode ?></th>
                <th class="hidden"><?= $borrowing->Id ?></th>
                <td scope="row"><?= $borrowing->CIN ?></td>
                <th scope="row"><?= $borrowing->Firstname ?></th>
                <th scope="row"><?= $borrowing->Lastname ?></th>
                <td><?= $borrowing->Title ?></td>
                <td><?= $borrowing->Category ?></td>
                <td><?= $borrowing->Author ?></td>
                <td><?= $borrowing->Inv ?></td>
                <td class="borrowing-date"><span><?= $borrowing->BorrowingDate ?></span></td>
                <td class="<?php echo !$borrowing->IsReturned ? 'due-date' : '' ?>"><span><?= $borrowing->DueDate ?></span></td>
                <?php if ($data['status'] === 'returned') : ?>
                  <td><?= $borrowing->ReturnedDate ?></td>
                <?php else : ?>
                  <td>
                    <button type="button" data-id="<?= $borrowing->Id ?>" data-barcode="<?= $borrowing->Barcode ?>" class="btn btn-outline-primary btn-search btn-action" data-bs-toggle="modal" data-bs-target="#confrimModal">
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                  </td>
                <?php endif ?>
              </tr>
            <?php endforeach ?>
          </tbody>
        <?php else : ?>
          <tr>
            <td>No borrowings found</td>
          </tr>
        <?php endif ?>
      </table>
      <!-- Modal -->
      <div class="modal fade" id="confrimModal" tabindex="-1" aria-labelledby="confrimModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confrimModalLabel"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= URLROOT ?>/borrowings/confirm" class="form-modal">
              <div class="modal-body">
                <div class="form-check text-start">
                  <input class="form-check-input" type="checkbox" name="sanction">
                  <label class="form-check-label" for="flexCheckIndeterminate">
                    <?= $language['borrowings_punish_msg'] ?>
                  </label>
                </div>
                <div class="mb-3 text-start">
                  <input type="hidden" name="barcode" class="form-control">
                  <input type="hidden" name="idborrowing" class="form-control">
                  <div class="hidden-part hidden">
                    <label class="form-label"><?= $language['table_end_date'] ?> : *</label>
                    <input type="date" name="enddate" class="form-control">
                    <label class="form-label"><?= $language['table_note'] ?> :</label>
                    <textarea type="text" name="note" class="form-control" placeholder="..."></textarea>

                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= $language['btn_close'] ?></a>
                <button type="submit" class="btn btn-outline-success"><?= $language['btn_returned'] ?></button>

              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script>
    (function() {
      const actionBtns = document.querySelectorAll('.btn-action');
      const formModal = document.querySelector('.form-modal');
      const modalTitle = document.querySelector('.modal-title');
      const sanction = document.querySelector('.form-modal input[type="checkbox"]');
      const hiddenPart = document.querySelector('.form-modal .hidden-part');
      sanction.addEventListener('change', () => {
        if (sanction.checked) {
          hiddenPart.classList.remove('hidden');
        } else {
          hiddenPart.classList.add('hidden');

        }
      })
      actionBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
          // Fill the from with clicked row data
          sanction.checked = false;
          const barcode = btn.dataset.barcode;
          const urlRoot = btn.dataset.urlRoot;
          const idBorrowing = btn.dataset.id;
          const tds_and_ths = btn.parentElement.parentElement.children;
          formModal.barcode.value = barcode;
          formModal.idborrowing.value = idBorrowing;
          modalTitle.textContent = `The "${tds_and_ths[3].textContent} ${tds_and_ths[4].textContent}" borrowing : `;

        });
      });

      // AJAX To Search For Borrowings
      const searchForm = document.querySelector('.search-form');
      const queryBox = document.querySelector('.search-form input[name="query"]');
      const orderby = document.querySelector('input[name="orderby"]:checked');
      const delayedBorrowings = document.getElementById('DelayedBorrowings');
      const desc = document.getElementById('Desc');

      if (queryBox) {
        queryBox.addEventListener('keyup', function(event) {
          filterBorrowings("<?= $data['status'] ?>");
        });
      }
      let listOfElements = [orderby, desc];
      if (delayedBorrowings) listOfElements.push(delayedBorrowings);
      listOfElements.forEach(el => {
        el.addEventListener('change', () => {
          filterBorrowings("<?= $data['status'] ?>")
        })
      })

      function filterBorrowings($status) {
        let url = "<?= URLROOT ?>" + '/borrowings';
        url += $status === 'returned' ? '/archive' : '';

        makeRequest(url, queryBox.value, orderby.id, delayedBorrowings && delayedBorrowings.checked, desc.checked);
      }

      let httpRequest = new XMLHttpRequest();

      function makeRequest(url, query = '', orderby = 'BorrowingDate', delayed = false, desc = false) {
        httpRequest.onreadystatechange = changeContent;
        url += `?query=${encodeURIComponent(query)}&orderby=${encodeURIComponent(orderby)}&delayed=${encodeURIComponent(delayed)}&desc=${encodeURIComponent(desc)}`;
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
            const borrowingsTable = document.querySelector('.table-borrowings');
            borrowingsTable.innerHTML = doc.querySelector('.table-borrowings').innerHTML;
            changeDateColor();
          } else {
            alert('There was a problem with the request.');
          }
        }
      }
    })();
  </script>