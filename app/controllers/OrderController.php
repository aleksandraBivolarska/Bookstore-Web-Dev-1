<?php
require_once __DIR__ . '/BaseController.php';

class OrderController extends BaseController
{

    function __construct()
    {

    }

    public function order()
    {
        require __DIR__ . '/../views/order.php';
    }

    
}
?>