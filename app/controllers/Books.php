<?php
class Books extends Controller
{
  private Book $bookModel;

  public function __construct()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }

    $this->bookModel = $this->model('Book');
  }

  public function index()
  {

    $data = [
      'books' => '',
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
      if (!empty(trim($_POST['query']))) {
        $books = $this->bookModel->findAvailableBooks($_POST['query']);
        $data['books'] = $books;
      }
    }

    $this->view('admins/index', $data);
  }

  public function findBookByInv()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
      $book = $this->bookModel->findBookByInv($_POST['code']);
      if ($book) {
        echo '
            <div class="card border-warning mb-3 book-card" style="max-width: 540px;">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="' . URLROOT . '/img/book.png" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">' . $book->Title . '</h5>
                    <ul class="card-text list-unstyled fw-normal pb-1">
                      <li>Inv : <small class="text-muted">' . $book->Inv . '</small></li>
                      <li>Author : <small class="text-muted">' . $book->Author . '</small></li>
                      <li>Cote : <small class="text-muted">' . $book->Cote . '</small></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
      ';
      } else {
        http_response_code(404);
        echo 'Book not found';
      }
    }
  }
}
