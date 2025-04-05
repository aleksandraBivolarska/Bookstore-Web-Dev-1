<?php
require_once __DIR__ . '/BaseController.php';

class StoreController extends BaseController
{

    function __construct()
    {

    }

    public function store()
    {
        require __DIR__ . '/../views/store.php';
    } 
}
?>