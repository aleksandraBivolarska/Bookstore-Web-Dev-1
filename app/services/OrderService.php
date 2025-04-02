<?
require __DIR__ . '/../repositories/OrderRepository.php';

class OrderService{
    private $orderRepository;
    function __construct(){
        $this->orderRepository = new OrderRepository();
    }

    public function getAllOrders(){
        return $this->orderRepository->getAllOrders();
    }

    public function getOrdersByUserId($user_id){
        return $this->orderRepository->getOrdersByUserId($user_id);
    }


    public function createOrder($order){
        return $this->orderRepository->createOrder($order);
    }

}