<?php
session_start();
require_once "../services/UserService.php";
require_once "../models/user.php";

class LoginController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login(): void
    {
        require_once "../views/login.php";
    }

    public function validateLogin($email, $password): void
    {
        $validatedUser = $this->userService->validateUser($email, $password);
        if ($validatedUser != null) {
            $userSerialized = serialize($validatedUser);
            $_SESSION['user'] = $userSerialized;
            
            require_once "../views/dashboard.php";
        } else {
            echo '<p id="message">Invalid username or password</p>';
            require_once "../views/login.php";
        }

        echo '<script>
            setTimeout(function(){
                document.getElementById("message").style.display = "none";
            }, 5000);
          </script>';
    }

    public function logout(): void
    {
        $_SESSION = array();
        session_destroy();
        header("Location: /login");
        exit();
    }
}