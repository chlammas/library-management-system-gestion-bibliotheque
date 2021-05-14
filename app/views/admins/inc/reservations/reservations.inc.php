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
  <div class="card text-center card-reservation">
    <div class="card-header">
      Reserved books :
    </div>
    <?php if (!empty($data['reservations'])) : ?>
      <div class="card-body">
        <span class="card-title"><strong></strong></span>
        <span class="card-text"></span>
      </div>
      <div class="table-responsive">
        <table class="table table-books ">
          <thead class="table-light">
            <tr>
              <th scope="col">Firstname</th>
              <th scope="col">Lastname</th>
              <th scope="col">ISBN</th>
              <th scope="col">Title</th>
              <th scope="col">Category</th>
              <th scope="col">Author</th>
              <th scope="col">Rack</th>
              <th scope="col">Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['reservations'] as $reservation) : ?>
              <tr class="clickable">
                <th scope="row"><?= $reservation->Firstname ?></th>
                <th scope="row"><?= $reservation->Lastname ?></th>
                <td><?= $reservation->ISBN ?></th>
                <td><?= $reservation->Title ?></td>
                <td><?= $reservation->Category ?></td>
                <td><?= $reservation->Author ?></td>
                <td><?= $reservation->Rack ?></td>
                <td><?= $reservation->Date ?></td>
                <td>
                  <button type="button" data-url-root="<?= URLROOT ?>" data-barcode="<?= $reservation->Barcode ?>" class="btn btn-outline-primary btn-search btn-action" data-bs-toggle="modal" data-bs-target="#confrimModal">
                    <i class="fas fa-ellipsis-h"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" id="confrimModal" tabindex="-1" aria-labelledby="confrimModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confrimModalLabel">Approve the borrowing :</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form method="POST" action="<?= URLROOT ?>/reservations/confirm" class="form-modal">
                <div class="modal-body">
                  <div class="mb-3 text-start">
                    <input type="hidden" name="barcode" class="form-control <?php echo (!empty($data['barcode_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['barcode'] ?? '' ?>">
                    <span class="invalid-feedback"><?php echo $data['barcode_err']; ?></span>
                    <label class="form-label">Full Name:</label>
                    <input type="text" name="fullname" class="form-control" value="<?= $data['fullname'] ?? '' ?>" readonly>
                    <label class="form-label">Book Inventory:</label>
                    <input type="text" name="inv" class="form-control <?php echo (!empty($data['inv_err'])) ? 'is-invalid' : ''; ?>" placeholder="Enter Inventory number" value="<?= $data['inv'] ?? '' ?>">
                    <span class="invalid-feedback"><?php echo $data['inv_err']; ?></span>
                  </div>
                </div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-outline-danger btn-delete-reservation">Delete</a>
                  <button type="submit" class="btn btn-outline-success">Approve</button>

                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    <?php else : ?>
      <p>No reservations found</p>
    <?php endif ?>
  </div>
  <script>
    // Delete or approve a reservation
    (function() {
      const actionBtns = document.querySelectorAll('.btn-action');
      const formModal = document.querySelector('.form-modal');
      const btnDeleteRes = document.querySelector(
        '.form-modal .btn-delete-reservation'
      );

      actionBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
          // Fill the form with clicked row data
          const barcode = btn.dataset.barcode;
          const urlRoot = btn.dataset.urlRoot;
          const tds = btn.parentElement.parentElement.children;
          formModal.barcode.value = barcode;
          formModal.fullname.value = tds[0].textContent + ' ' + tds[1].textContent;
          // To delete the reservation
          btnDeleteRes.href = urlRoot + '/reservations/cancel/' + barcode;


        });
      });
    })();

  </script>