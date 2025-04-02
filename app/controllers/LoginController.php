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
            // Serialize the object
            $userSerialized = serialize($validatedUser);
            // Store the serialized object in a session variable
            $_SESSION['user'] = $userSerialized;
            
            require_once "../views/dashboard.php";
        } else {
            echo '<p id="message">Invalid username or password</p>';
            require_once "../views/login.php";
        }

        // Output JavaScript code to remove the message after 3 seconds
        echo '<script>
            setTimeout(function(){
                document.getElementById("message").style.display = "none";
            }, 3000);
          </script>';
    }


    public function logout(): void
    {
        // Clear all session variables
        $_SESSION = array();
        
        // Destroy the session
        session_destroy();
        
        // Clear the cart from localStorage (this will be handled by JavaScript)
        // Redirect to login page
        header("Location: /login");
        exit();
    }
}