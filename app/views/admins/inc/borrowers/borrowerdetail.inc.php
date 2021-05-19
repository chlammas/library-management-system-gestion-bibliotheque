  <div class="main-body">
    <div class="row gutters-sm">
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="<?= URLROOT ?>/img/user.png" alt="Admin" class="rounded-circle" width="150">
              <div class="mt-3">
                <h4><?= $data['borrower']->Firstname . ' ' . $data['borrower']->Lastname ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0"><?= $language['table_cin'] ?></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $data['borrower']->CIN ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0"><?= $language['table_program'] ?></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $data['borrower']->Program ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0"><?= $language['table_status'] ?></h6>
              </div>
              <div class="col-sm-9 text-<?= $data['borrower']->Status === 'Active' ? 'success' : 'danger' ?>">
                <?= $language['table_status_' . strtolower($data['borrower']->Status)] ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-3">
        <div class="card h-100">
          <div class="card-body">
            <h6 class="d-flex align-items-center mb-3"><?= $language['borrowings_history'] ?></h6>
            <div class="table-responsive">
              <table class="table table-borrowings">
                <?php if (!empty($data['borrower_borrowings'])) : ?>
                  <thead class="table-light">
                    <tr>
                      <th class="col hidden"><?= $language['table_id'] ?></th>
                      <th scope="col"><?= $language['table_title'] ?></th>
                      <th scope="col"><?= $language['table_category'] ?></th>
                      <th scope="col"><?= $language['table_author'] ?></th>
                      <th scope="col"><?= $language['table_inv'] ?></th>
                      <th scope="col"><?= $language['table_borrowing_date'] ?></th>
                      <th scope="col"><?= $language['table_due_date'] ?></th>
                      <th scope="col"><?= $language['table_returned_date'] ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data['borrower_borrowings'] as $borrowing) : ?>
                      <tr class="clickable">
                        <th class="hidden"><?= $borrowing->Id ?></th>
                        <td><?= $borrowing->Title ?></td>
                        <td><?= $borrowing->Category ?></td>
                        <td><?= $borrowing->Author ?></td>
                        <td><?= $borrowing->Inv ?></td>
                        <td class="borrowing-date"><span><?= $borrowing->BorrowingDate ?></span></td>
                        <td class="<?php echo !$borrowing->IsReturned ? 'due-date' : '' ?>"><span><?= $borrowing->DueDate ?></span></td>
                        <td><?= $borrowing->ReturnedDate ?? 'Not yet' ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                <?php else : ?>
                  <tr>
                    <td><?= $language['borrowings_not_found'] ?></td>
                  </tr>
                <?php endif ?>
              </table>
        
            </div>

          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-3">
        <div class="card h-100">
          <div class="card-body">
            <h6 class="d-flex align-items-center mb-3"><?= $language['sanctions_history'] ?></h6>
            <div class="table-responsive">
              <table class="table table-borrowings">
                <?php if (!empty($data['borrower_sanctions'])) : ?>
                  <thead class="table-light">
                    <tr>
                      <th class="col hidden"><?= $language['table_id'] ?></th>
                      <th scope="col"><?= $language['table_end_date'] ?></th>
                      <th scope="col"><?= $language['table_remaining'] ?></th>
                      <th scope="col">Note</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data['borrower_sanctions'] as $sanction) : ?>
                      <tr class="clickable">
                        <th class="hidden"><?= $sanction->Id ?></th>
                        <td><?= $sanction->EndDate ?></td>
                        <td><?= $sanction->Remaining > 0 ? ($sanction->Remaining === 1 ? $sanction->Remaining . ' ' . $language['day'] : $sanction->Remaining . ' ' . $language['day'] . 's') : $language['ended'] ?></td>
                        <td><?= $sanction->Note == '' ? '...' : $sanction->Note ?></td>
                        
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                <?php else : ?>
                  <tr>
                    <td><?= $language['sanctions_not_found'] ?></td>
                  </tr>
                <?php endif ?>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>