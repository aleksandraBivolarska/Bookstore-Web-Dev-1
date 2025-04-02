<?
require __DIR__ . '/../repositories/BookRepository.php';

class BookService{
    private $bookRepository;
    function __construct(){
        $this->bookRepository = new BookRepository();
    }

    public function getAllBooks(){
        return $this->bookRepository->getAllBooks();
    }

    public function getBookById($book_id) {
        return $this->bookRepository->getBookById($book_id);
    }

    public function createBook($book){
        return $this->bookRepository->createBook($book);
    }

    public function deleteBook($book_id) {
        return $this->bookRepository->deleteBook($book_id);
    }
    
    public function editBook($book){
        return $this->bookRepository->editBook($book);
    }
}