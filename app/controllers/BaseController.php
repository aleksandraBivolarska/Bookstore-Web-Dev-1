<?php
class BaseController
{
    // private $userService;

    // function __construct()
    // {
    //     $this->userService = new UserService();
    // }

    function displayView($model)
    {
        $directory = substr(get_class($this), 0, -10);
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../views/$directory/$view.php";
    }

}
?>