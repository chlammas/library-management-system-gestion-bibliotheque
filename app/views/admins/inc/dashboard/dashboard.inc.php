<div class="main-body">
  <div class="row gutters-sm">

    <div class="col-md-12">
      <div class="card mb-3">
        <div class="card-body">
          <canvas id="myChart" style="width:100%;max-width:900px;height: 300px;"></canvas>
        </div>
      </div>

    </div>
    <div class="col-sm-12 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <h6 class="d-flex align-items-center mb-3">Most Borrowed Books</h6>
          <div class="table-responsive">
            <table class="table table-borrowings">
              <thead class="table-light">
                <tr>
                  <th scope="col">ISBN</th>
                  <th scope="col">Title</th>
                  <th scope="col">Type</th>
                  <th scope="col">Category</th>
                  <th scope="col">Edition</th>
                  <th scope="col">Rack</th>
                  <th scope="col">Author</th>
                  <th scope="col">Status</th>
                  <th scope="col">Borrowings</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (Statistics::BorrowedBooks(5) as $book) : ?>
                  <tr class="clickable">
                    <td><?= $book->ISBN ?></td>
                    <th><?= $book->Title ?></th>
                    <td><?= $book->Type ?></td>
                    <td><?= $book->Category ?></td>
                    <td><?= $book->Edition ?></td>
                    <td><?= $book->Rack ?></td>
                    <td><?= $book->Author ?></td>
                    <td><?= $book->Status ?></td>
                    <td class="text-center"><?= $book->Borrowings ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>
    <div class="col-sm-12 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <h6 class="d-flex align-items-center mb-3">Delayed Borrowings</h6>
          <div class="table-responsive">
            <table class="table table-borrowings">
              <thead class="table-light">
                <tr>
                  <th class="col hidden">Id</th>
                  <th scope="col">CIN</th>
                  <th scope="col">Firstname</th>
                  <th scope="col">Lastname</th>
                  <th scope="col">Title</th>
                  <th scope="col">Category</th>
                  <th scope="col">Author</th>
                  <th scope="col">Inv</th>
                  <th scope="col">BorrowingDate</th>
                  <th scope="col">DueDate</th>

                </tr>
              </thead>
              <tbody>
                <?php foreach (Statistics::DelayedBorrowings() as $borrowing) : ?>
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
                    <td class="borrowing-date"><span><?= $borrowing->BorrowingDate ?></span>
                    </td>
                    <td class="due-date"><span><?= $borrowing->DueDate ?></span></td>
                  </tr>
                <?php endforeach ?>
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<script>
  new Chart(document.getElementById("myChart"), {
    type: 'line',
    data: {
      labels: [
        <?php foreach (array_reverse(Statistics::BorrowingsNumberPerDate()) as $borrowing) {
          echo "'" . $borrowing->BorrowingDate . "',";
        } ?>
      ],
      datasets: [{
        data: [
          <?php foreach (array_reverse(Statistics::BorrowingsNumberPerDate()) as $borrowing) {
            echo $borrowing->Number . ",";
          } ?>
        ],
        label: "Borrowings number",
        borderColor: "#948e95",
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Borrowings Number Per Date'
        },
      }
    }
  });
</script>