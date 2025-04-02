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


}

?>
