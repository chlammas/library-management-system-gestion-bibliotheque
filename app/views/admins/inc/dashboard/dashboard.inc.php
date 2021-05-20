<style>
  .chart2 {

    height: 500px !important;

  }
</style>
<div class="main-body">
  <div class="row gutters-sm">

    <div class="col-md-12">
      <div class="card mb-3">
        <div class="card-body">
          <canvas id="myChart" style="width:100%;max-width:900px;height: 300px;"></canvas>
          <div class="chart2">
            <canvas id="myChart2" style="width:100%;max-width:900px;height: 300px;"></canvas>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-12 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <h6 class="d-flex align-items-center mb-3"><?= $language['dashboard_most_borrowed_books'] ?></h6>
          <div class="table-responsive">
            <table class="table table-borrowings">
              <thead class="table-light">
                <tr>
                  <th scope="col"><?= $language['table_isbn'] ?></th>
                  <th scope="col"><?= $language['table_title'] ?></th>
                  <th scope="col"><?= $language['table_type'] ?></th>
                  <th scope="col"><?= $language['table_category'] ?></th>
                  <th scope="col"><?= $language['table_edition'] ?></th>
                  <th scope="col"><?= $language['table_edition'] ?></th>
                  <th scope="col"><?= $language['table_author'] ?></th>
                  <th scope="col"><?= $language['table_status'] ?></th>
                  <th scope="col"><?= $language['table_borrowings'] ?></th>
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
                    <td><?= $book->Status === 'Available' ? $language['table_status_available'] : '<strong class="text-warning">' . $language['table_status_out_of_stock'] . '</strong>' ?></td>
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
          <h6 class="d-flex align-items-center mb-3"><?= $language['delayed_borrowings'] ?></h6>
          <div class="table-responsive">
            <table class="table table-borrowings">
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
        label: "<?= $language['dashboard_chart_label'] ?>",
        borderColor: "#948e95",
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: "<?= $language['dashboard_chart_title'] ?>"
        },
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


  /*********** */

  const labels = [
    "<?= ucfirst($language['book']) . 's' ?>",
    "<?= $language['copies'] ?>",
    "<?= $language['Borrowed_copies'] ?>",
    "<?= $language['available_copies'] ?>",
    "<?= $language['out_of_stock_books'] ?>"
  ];
  const data = {
    labels: labels,
    datasets: [{
      label: 'My First Dataset',
      data: [<?= Statistics::booksCount() ?>, <?= Statistics::CopiesCount() ?>, <?= Statistics::BorrowedCopiesCount() ?>, <?= Statistics::AvailableCopiesCount() ?>, <?= Statistics::OutOfStockBooksCount() ?>],
      backgroundColor: [
        'rgba(0, 0, 255, 0.7)',
        'rgba(0, 100, 255, 0.5)',
        'rgba(155, 155, 0, 0.5)',
        'rgba(0, 255, 0, 0.5)',
        'rgba(255, 0, 0, 0.5)',
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
      ],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'pie',
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: "<?= $language['dashboard_chart2_title'] ?>"
        },
      },
      scales: {

      }
    },
  };
  new Chart(
    document.getElementById('myChart2'),
    config
  );
</script>