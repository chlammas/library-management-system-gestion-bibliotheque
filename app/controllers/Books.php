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
      'query' => isset($_GET['query']) ? trim($_GET['query']) : '',
      'available' => isset($_GET['available']) ? filter_var(trim($_GET['available']), FILTER_VALIDATE_BOOLEAN) : null
    ];

    $books = $this->bookModel->findBooks($data['query'], $data['available']);
    $data['books'] = $books;

    $this->view('admins/index', $data);
  }

  public function findBookByInv()
  {
    if (!isAdminLoggedIn()) {
      redirect('');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
      $book = $this->bookModel->findBookByInv(trim($_POST['code']));
      if ($book) {
        echo '
            <div class="card border-success mb-3 book-card" style="max-width: 540px;">
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
                      <li>Rack : <small class="text-muted">' . $book->Rack . '</small></li>
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

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      list($noError, $err_msg, $data) = $this->validateRequest($_POST);

      // Make sure there is no error
      if ($noError) {
        try {
          $this->bookModel->add($data['isbn'], $data['title'], $data['type'], $data['category'], $data['edition'], $data['rack'], $data['author']);
          flash('book', 'Book was added successfully!');
          redirect('books');
        } catch (PDOException $e) {
          $expectedError = 'This book was already added!';
          if (strpos($e->getMessage(), $expectedError) !== false) {
            flash('book', $expectedError, 'alert alert-danger');
            $data['isbn_err'] = $expectedError;
          } else {
            flash('book', 'Something wrong!', 'alert alert-danger');
          }
          $data['add_book'] = true;
          $this->view('admins/index', $data);
        }
      } else {
        flash('reservation', $err_msg, 'alert alert-danger');
        $data['add_book'] = true;
        $this->view('admins/index', $data);
      }
    } else {
      $data = [
        'add_book' => true,
      ];
      $this->view('admins/index', $data);
    }
  }

  public function edit($isbn)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      list($noError, $err_msg, $data) = $this->validateRequest($_POST);
      
      // Make sure there is no error
      if ($noError) {
        try {
          $this->bookModel->edit($isbn, $data['isbn'], $data['title'], $data['type'], $data['category'], $data['edition'], $data['rack'], $data['author']);
          flash('book', 'Book was updated successfully!');
          redirect('books');
        } catch (PDOException $e) {
            flash('book', 'Something wrong!', 'alert alert-danger');
            $data['edit_book'] = true;
            $this->view('admins/index', $data);
        }
      } else {
        flash('book', $err_msg, 'alert alert-danger');
        $data['edit_book'] = true;
        $this->view('admins/index', $data);
      }
    } else {
      $book = $this->bookModel->findBookByISBN($isbn);
      if (!$book) {
        redirect('books');
      } else {
        $data = [
          'edit_book' => true,
          'isbn' => $book->ISBN,
          'title' => $book->Title,
          'type' => $book->Type,
          'category' => $book->Category,
          'edition' => $book->Edition,
          'rack' => $book->Rack,
          'author' => $book->Author,
        ];

        $this->view('admins/index', $data);
      }
    }
  }

  private function validateRequest($request)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $request = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'isbn' => isset($request['isbn']) ? trim($request['isbn']) : '',
        'isbn_err' => '',
        'title' => isset($request['title']) ? trim($request['title']) : '',
        'title_err' => '',
        'type' => isset($request['type']) ? trim($request['type']) : '',
        'type_err' => '',
        'category' => isset($request['category']) ? trim($request['category']) : '',
        'category_err' => '',
        'edition' => isset($request['edition']) ? trim($request['edition']) : '',
        'edition_err' => '',
        'rack' => isset($request['rack']) ? trim($request['rack']) : '',
        'rack_err' => '',
        'author' => isset($request['author']) ? trim($request['author']) : '',
        'author_err' => '',
      ];

      if (empty($data['isbn'])) {
        $data['isbn_err'] = 'Please enter a valid ISBN';
      }
      if (empty($data['title'])) {
        $data['title_err'] = 'Please enter a valid title';
      }
      if (empty($data['type'])) {
        $data['type_err'] = 'Please enter a valid type';
      }
      if (empty($data['category'])) {
        $data['category_err'] = 'Please enter a valid category';
      }
      if (empty($data['edition'])) {
        $data['edition_err'] = 'Please enter a valid edition';
      }
      if (empty($data['rack'])) {
        $data['rack_err'] = 'Please enter a valid rack';
      }
      if (empty($data['author'])) {
        $data['author_err'] = 'Please enter a valid author';
      }

      // Make sure there is no error
      $noError = empty($data['isbn_err']) && empty($data['title_err']) && empty($data['type_err']) && empty($data['category_err']) && empty($data['edition_err']) && empty($data['rack_err']) && empty($data['author_err']);

      
        $err_msg = '<ul>';
        $err_msg .= $data['isbn_err'] ?  '<li>' . $data['isbn_err'] . '</li>' : '';
        $err_msg .= $data['title_err'] ?  '<li>' . $data['title_err'] . '</li>' : '';
        $err_msg .= $data['type_err'] ?  '<li>' . $data['type_err'] . '</li>' : '';
        $err_msg .= $data['category_err'] ?  '<li>' . $data['category_err'] . '</li>' : '';
        $err_msg .= $data['edition_err'] ?  '<li>' . $data['edition_err'] . '</li>' : '';
        $err_msg .= $data['rack_err'] ?  '<li>' . $data['rack_err'] . '</li>' : '';
        $err_msg .= $data['author_err'] ?  '<li>' . $data['author_err'] . '</li>' : '';
        $err_msg .= '</ul>';

        return [$noError, $err_msg, $data];

      
    } else {}
  }
}
