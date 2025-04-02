<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../services/BookService.php'; 

class ShoppingCartController extends BaseController
{
    private $bookService;

    function __construct()
    {
        $this->bookService = new BookService();
    }

    public function shoppingCart()
    {
        // For new book creation
        require __DIR__ . '/../views/shopping-cart.php';
    }

  
}
?>