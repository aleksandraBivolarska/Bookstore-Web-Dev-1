<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../services/OrderService.php';

class OrderControllerAPI
{
    private OrderService $service;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    public function orders(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: GET, OPTIONS');

        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            http_response_code(200);
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $orders = $this->service->getAllOrders();

            header('Content-Type: application/json');
            echo json_encode($orders);
            exit();
        }

        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit();
    }

    public function customerOrders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: GET, OPTIONS');

        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            http_response_code(200);
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $uri = $_SERVER['REQUEST_URI'];
            $parts = explode('/', $uri);
            $user_id = end($parts);
            
            if (is_numeric($user_id)) {
                $this->service->getOrdersByUserId($user_id);
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Invalid book ID."));
            }
            $order = $this->service->getOrdersByUserId($user_id);

            header('Content-Type: application/json');
            echo json_encode($order);
            exit();
        }

        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit();
    }

    public function createOrder()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Get bookId from URL
                $uri = $_SERVER['REQUEST_URI'];
                $parts = explode('/', $uri);
                $book_id = end($parts);
    
                if (!is_numeric($book_id)) {
                    http_response_code(400);
                    echo json_encode(["error" => "Invalid book ID"]);
                    exit();
                }
                
                
                if (!isset($_SESSION['user'])) {
                    http_response_code(401);
                    echo json_encode(["error" => "User not logged in"]);
                    exit();
                }
    
                $user = unserialize($_SESSION['user']);
                $user_id = $user['user_id'];
                $quantity = 1;
    
                // Create order object
                $order = new Order(null, $user_id, null, null, $book_id, null, null, $quantity);
    
                // Call service to create order
                $order_id = $this->service->createOrder($order);
    
                if ($order_id) {
                    http_response_code(201);
                    echo json_encode(["message" => "Book added to cart successfully", "order_id" => $order_id]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Failed to add book to cart"]);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(["error" => $e->getMessage()]);
            }
            exit();
        }
    
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit();
    }
}

?>
