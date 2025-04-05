<?php
require_once __DIR__ . '/../services/BookService.php';

class BookControllerAPI
{
    private BookService $service;

    public function __construct()
    {
        $this->service = new BookService();
    }

    public function store(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: GET, OPTIONS');

        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            http_response_code(200);
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $books = $this->service->getAllBooks();

            header('Content-Type: application/json');
            echo json_encode($books);
            exit();
        }
    
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit();
    }
    
    function deleteBook() {

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            http_response_code(405);
            echo json_encode(["message" => "Method Not Allowed"]);
            exit();
        }
    
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uriParts = explode('/', $uri);
        $book_id = (int)end($uriParts);
    
        $this->service->deleteBook($book_id);
    }

    public function addBook()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // if image was not provided, upload the default to the database
            $imageUrl = !empty($_POST['imageUrl']) ? $_POST['imageUrl'] : 'https://pngimg.com/d/book_PNG51088.png';
            
            $book = new Book(
                0, 
                $_POST['title'],
                $_POST['author'],
                $_POST['genre'],
                (int)$_POST['stock'],
                (float)$_POST['price'],
                $imageUrl
            );
      
            $bookService = new BookService();
            $bookService->createBook($book);
        }
    
        header("Location: /book-management");
        exit();
    }

    public function updateBook(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');

        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            http_response_code(200);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
            try {
                
                $existingBook = $this->service->getBookById((int)$_POST['book_id']);
                
                $imageUrl = $_POST['imageUrl'] ?? $existingBook->getImageUrl() ?? 'https://pngimg.com/d/book_PNG51088.png';

                $book = new Book(
                    (int)$_POST['book_id'],
                    htmlspecialchars($_POST['title']),
                    htmlspecialchars($_POST['author']),
                    htmlspecialchars($_POST['genre']),
                    (int)$_POST['stock'],
                    (float)$_POST['price'],
                    $imageUrl
                );

                $this->service->editBook($book);
                header("Location: /book-management");
                exit();
            } catch (Exception $e) {
                error_log("Error updating book: " . $e->getMessage());
                http_response_code(500);
                echo json_encode(["error" => "Failed to update book"]);
                exit();
            }
        }

        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit();
    }


}

?>
