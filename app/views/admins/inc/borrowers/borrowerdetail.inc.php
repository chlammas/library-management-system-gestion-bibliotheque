  <div class="main-body">
    <div class="row gutters-sm">
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="<?= URLROOT ?>/img/user.png" alt="Admin" class="rounded-circle" width="150">
              <div class="mt-3">
                <h4><?= $data['borrower']->Firstname . ' ' . $data['borrower']->Lastname ?></h4>
                <!--  <p class="text-secondary mb-1">Full Stack Developer</p>
                <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                <button class="btn btn-primary">Follow</button>
                <button class="btn btn-outline-primary">Message</button> -->
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="card mt-3">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="2" y1="12" x2="22" y2="12"></line>
                  <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                </svg>Website</h6>
              <span class="text-secondary">https://bootdey.com</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                  <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                </svg>Github</h6>
              <span class="text-secondary">bootdey</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
                  <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                </svg>Twitter</h6>
              <span class="text-secondary">@bootdey</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
                  <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                  <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                  <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>Instagram</h6>
              <span class="text-secondary">bootdey</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
                  <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                </svg>Facebook</h6>
              <span class="text-secondary">bootdey</span>
            </li>
          </ul>
        </div> -->
      </div>
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">CIN</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $data['borrower']->CIN ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Program</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $data['borrower']->Program ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Status</h6>
              </div>
              <div class="col-sm-9 text-<?= $data['borrower']->Status === 'Active' ? 'success' : 'danger' ?>">
                <?= $data['borrower']->Status ?>
              </div>
            </div>
            <!-- <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Mobile</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                (320) 380-4539
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Address</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                Bay Area, San Francisco, CA
              </div>
            </div> -->
          </div>
        </div>

      </div>
      <div class="col-sm-12 mb-3">
        <div class="card h-100">
          <div class="card-body">
            <h6 class="d-flex align-items-center mb-3">Borrowings History</h6>
            <div class="table-responsive">
              <table class="table table-borrowings">
                <?php if (!empty($data['borrower_borrowings'])) : ?>
                  <thead class="table-light">
                    <tr>
                      <th class="col hidden">Id</th>
                      <th scope="col">Title</th>
                      <th scope="col">Category</th>
                      <th scope="col">Author</th>
                      <th scope="col">Inv</th>
                      <th scope="col">BorrowingDate</th>
                      <th scope="col">DueDate</th>
                      <th scope="col">ReturnedDate</th>
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
                            Punish the borrower before completing the process?
                          </label>
                        </div>
                        <div class="mb-3 text-start">
                          <input type="hidden" name="barcode" class="form-control">
                          <input type="hidden" name="idborrowing" class="form-control">
                          <div class="hidden-part hidden">
                            <label class="form-label">End Date : *</label>
                            <input type="date" name="enddate" class="form-control">
                            <label class="form-label">Note :</label>
                            <textarea type="text" name="note" class="form-control" placeholder="..."></textarea>

                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-outline-success">Returned</button>

                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-3">
        <div class="card h-100">
          <div class="card-body">
            <h6 class="d-flex align-items-center mb-3">Sanctions History</h6>
            <div class="table-responsive">
              <table class="table table-borrowings">
                <?php if (!empty($data['borrower_sanctions'])) : ?>
                  <thead class="table-light">
                    <tr>
                      <th class="col hidden">Id</th>
                      <th scope="col">EndDate</th>
                      <th scope="col">Remaining</th>
                      <th scope="col">Note</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data['borrower_sanctions'] as $sanction) : ?>
                      <tr class="clickable">
                        <th class="hidden"><?= $sanction->Id ?></th>
                        <td><?= $sanction->EndDate ?></td>
                        <td><?= $sanction->Remaining > 0 ? ($sanction->Remaining === 1 ? $sanction->Remaining . ' day': $sanction->Remaining . ' days') : 'Ended' ?></td>
                        <td><?= $sanction->Note == '' ? '...' : $sanction->Note ?></td>
                        
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                <?php else : ?>
                  <tr>
                    <td>No sanctions found</td>
                  </tr>
                <?php endif ?>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>