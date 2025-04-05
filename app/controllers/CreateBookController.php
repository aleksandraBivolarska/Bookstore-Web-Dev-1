<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../services/BookService.php'; 

class CreateBookController extends BaseController
{
    private $bookService;

    function __construct()
    {
        $this->bookService = new BookService();
    }

    public function createBook()
    {
        // For new book creation
        require __DIR__ . '/../views/create-book.php';
    }
 
}
?>