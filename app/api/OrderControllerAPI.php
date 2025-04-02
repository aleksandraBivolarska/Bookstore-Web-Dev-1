<?php
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


}

?>
