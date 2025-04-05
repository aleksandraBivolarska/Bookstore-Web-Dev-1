<?php
require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../models/order.php';

class OrderRepository extends BaseRepository {
    
    function getAllOrders() {
        try {
            $stmt = $this->connection->prepare(
                "SELECT 
                    o.order_id, 
                    o.user_id, 
                    u.first_name as user_first_name, 
                    u.last_name as user_last_name,
                    o.book_id, 
                    b.title as book_title, 
                    b.author as book_author,
                    o.quantity
                FROM `order` o
                JOIN user u ON o.user_id = u.user_id
                JOIN book b ON o.book_id = b.book_id"
            );
            $stmt->execute();
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $ordersArray = $stmt->fetchAll();
    
            $orders = [];
            foreach ($ordersArray as $orderData) {
                $orders[] = new Order(
                    $orderData['order_id'],
                    $orderData['user_id'],
                    $orderData['user_first_name'],
                    $orderData['user_last_name'],
                    $orderData['book_id'],
                    $orderData['book_title'],
                    $orderData['book_author'],
                    $orderData['quantity']
                );
            }

            return $orders;
        } catch (PDOException $e) {
            error_log("Error in getAllOrders: " . $e->getMessage());
            return [];
        }
    }

    function getOrdersByUserId($user_id) {
        try {
            $stmt = $this->connection->prepare(
                "SELECT 
                    o.order_id, 
                    o.user_id, 
                    u.first_name as user_first_name, 
                    u.last_name as user_last_name,
                    o.book_id, 
                    b.title as book_title, 
                    b.author as book_author,
                    o.quantity
                FROM `order` o
                JOIN user u ON o.user_id = u.user_id
                JOIN book b ON o.book_id = b.book_id
                WHERE o.user_id = :user_id"
            );
            
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $ordersArray = $stmt->fetchAll();
    
            $orders = [];
            foreach ($ordersArray as $orderData) {
                $orders[] = new Order(
                    $orderData['order_id'],
                    $orderData['user_id'],
                    $orderData['user_first_name'],
                    $orderData['user_last_name'],
                    $orderData['book_id'],
                    $orderData['book_title'],
                    $orderData['book_author'],
                    $orderData['quantity']
                );
            }
    
            return $orders;
        } catch (PDOException $e) {
            error_log("Error in getOrdersByUserId: " . $e->getMessage());
            return [];
        }
    }

    function createOrder($order) {
        try {
            // Ensure quantity is always 1
            $quantity = 1;
            
            $stmt = $this->connection->prepare(
                "INSERT INTO `order`(`order_id`, `user_id`, `book_id`, `quantity`) 
                VALUES (NULL, :user_id, :book_id, :quantity)"
            );
            $user_id = $order->getUserId();
            $book_id = $order->getBookId();
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":book_id", $book_id);
            $stmt->bindParam(":quantity", $quantity); // Use the fixed quantity
    
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error in createOrder: " . $e->getMessage());
            return false;
        }
    }
}