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
}
