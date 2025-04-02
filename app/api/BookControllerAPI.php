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

        // Handle preflight request for CORS
        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            http_response_code(200);
            exit();
        }

        // Handle GET request to fetch all books
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $books = $this->service->getAllBooks();

            header('Content-Type: application/json');
            echo json_encode($books);
            exit();
        }

    
        // If request method is unsupported, return an error
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit();
    }


    function deleteBook() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: DELETE, OPTIONS");
    
        // Handle preflight request
        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            http_response_code(200);
            exit();
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            // Extract ID from URL
            $uri = $_SERVER['REQUEST_URI'];
            $parts = explode('/', $uri);
            $book_id = end($parts);
            
            if (is_numeric($book_id)) {
                $this->service->deleteBook($book_id);
                http_response_code(200);
                echo json_encode(array("message" => "Book was deleted."));
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Invalid book ID."));
            }
        } else {
            http_response_code(405);
            echo json_encode(array("message" => "Method Not Allowed"));
        }
    }

    public function addBook()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Use provided image URL or fallback to default
            $imageUrl = !empty($_POST['imageUrl']) ? $_POST['imageUrl'] : 'https://pngimg.com/d/book_PNG51088.png';
            
            // Create new Book object
            $book = new Book(
                0, // book_id will be auto-generated by database
                $_POST['title'],
                $_POST['author'],
                $_POST['genre'],
                (int)$_POST['stock'],
                (float)$_POST['price'],
                $imageUrl
            );
      
            // Create book via service
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

    // Handle preflight request for CORS
    if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
        http_response_code(200);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
        try {
            // Get existing book to preserve image if not provided
            $existingBook = $this->service->getBookById((int)$_POST['book_id']);
            
            // Use submitted image or existing image or default
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
            
            // Redirect back to book management
            header("Location: /book-management");
            exit();
        } catch (Exception $e) {
            // Handle any errors that occur during the process
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
