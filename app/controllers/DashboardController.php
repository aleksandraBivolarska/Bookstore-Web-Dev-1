<?php
require_once __DIR__ . '/BaseController.php';

class DashboardController extends BaseController
{

    function __construct()
    {

    }

    public function dashboard()
    {
        require __DIR__ . '/../views/dashboard.php';
    }

    
}
?>