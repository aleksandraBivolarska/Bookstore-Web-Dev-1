<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../services/BookService.php'; 

class BookEditController extends BaseController
{
    private $bookService;

    function __construct()
    {
        $this->bookService = new BookService();
    }

    public function editBook() {
        $uri = $_SERVER['REQUEST_URI'];
        $parts = explode('/', $uri);
        $bookId = end($parts);
        
        $book = $this->bookService->getBookById($bookId);
        
        // Convert Book object to array
        $bookData = [
            'book_id' => $book->getBookId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'genre' => $book->getGenre(),
            'stock' => $book->getStock(),
            'price' => $book->getPrice(),
            'image' => $book->getImageUrl()
        ];
        
        include __DIR__ . '/../Views/edit-book.php';
    }

}
?>