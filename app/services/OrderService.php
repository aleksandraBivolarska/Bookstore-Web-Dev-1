<?
require_once __DIR__ . '/../repositories/OrderRepository.php';
require_once __DIR__ . '/../repositories/BookRepository.php';

class OrderService{
    private $orderRepository;
    private $bookRepository;
    
    function __construct() {
        $this->orderRepository = new OrderRepository();
        $this->bookRepository = new BookRepository();
    }

    public function getAllOrders(){
        return $this->orderRepository->getAllOrders();
    }

    public function getOrdersByUserId($user_id){
        return $this->orderRepository->getOrdersByUserId($user_id);
    }


    public function createOrder($order) {
        try {
            // Start transaction
            // $this->orderRepository->beginTransaction();
            
            // 1. Check stock availability
            $book = $this->bookRepository->getBookById($order->getBookId());
            if (!$book || $book->getStock() <= 0) {
                throw new Exception("Book is out of stock");
            }
            
            // 2. Create the order
            $orderId = $this->orderRepository->createOrder($order);
            if (!$orderId) {
                throw new Exception("Failed to create order");
            }
            
            // 3. Update book stock (decrement by 1)
            $book->setStock($book->getStock() - 1);
            $this->bookRepository->editBook($book);
            
            return $orderId;
        } catch (Exception $e) {
            error_log("Order creation failed: " . $e->getMessage());
            return false;
        }
    }

}