<?php
require_once __DIR__ . '/BaseController.php';

class BookManagementController extends BaseController
{
    function __construct()
    {

    }

    public function bookManagement()
    {
        require __DIR__ . '/../views/book-management.php';
    }
    
}
?>