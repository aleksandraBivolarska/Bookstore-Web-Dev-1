<?php
$page = $_SERVER['REQUEST_URI'];

switch ($page) {
    case"/":
    case "/dashboard":
        case"/home":
            require_once "../Controllers/DashboardController.php";
            $controller = new DashboardController();
            $controller->dashboard();
            break;
        case"/view/login":
        case"/login":
            require_once "../Controllers/LoginController.php";
            $controller = new LoginController();
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
                $password = htmlspecialchars($_POST['password']);
                $controller->validateLogin($email, $password);
            } else {
                $controller->login();
            }
            break;
        case "/logout":
            require_once "../Controllers/LoginController.php";
            $controller = new LoginController();
            $controller->logout();
            break;
        case "/store":
            require_once "../Controllers/StoreController.php";
            $controller = new StoreController();
            $controller->store();
            break;

        case "/shopping-cart":
            require_once "../Controllers/ShoppingCartController.php";
            $controller = new ShoppingCartController();
            $controller->shoppingCart();
            break;
    
        case '/book-management':
            require_once "../Controllers/BookManagementController.php";
            $controller = new BookManagementController();
            $controller->bookManagement();
            break;
        case '/createBook':
            require_once "../Controllers/CreateBookController.php";
            $controller = new CreateBookController();
            $controller->createBook();
            break;

        case (preg_match('/^\/editBook\/\d+$/', $page) ? true : false):
            require_once "../Controllers/BookEditController.php";
            $controller = new BookEditController();
            $controller->editBook();
            break;
          
        case '/api/books':
            require_once "../api/BookControllerAPI.php";
            $controller = new BookControllerAPI();
            $controller->store();
            break;
       
            case (preg_match('/^\/api\/books\/deleteBook\/\d+$/', $page) ? true : false):
                require_once "../api/BookControllerAPI.php";
                $controller = new BookControllerAPI();
                $controller->deleteBook();
                break;

        case "/api/books/addBook":
            require_once "../api/BookControllerAPI.php";
            $controller = new BookControllerAPI();
            $controller->addBook();
            break;

        case "/api/books/updateBook":
            require_once "../api/BookControllerAPI.php";
            $controller = new BookControllerAPI();
            $controller->updateBook();
            break;

        case "/order":
            require_once"../controllers/OrderController.php";
            $controller = new OrderController();
            $controller->order();
            break;
        case '/api/orders':
            require_once "../api/OrderControllerAPI.php";
            $controller = new OrderControllerAPI();
            $controller->orders();
            break;
            case (preg_match('/^\/api\/orders\/create\/\d+$/', $page) ? true : false):
                require_once "../api/OrderControllerAPI.php";
                $controller = new OrderControllerAPI();
                $controller->createOrder();
                break;
        case (preg_match('/^\/api\/orders\/\d+$/', $page) ? true : false):
            require_once "../api/OrderControllerAPI.php";
            $controller = new OrderControllerAPI();
            $controller->customerOrders();
            break;
        default:
            // Handle 404 error
            http_response_code(404);
            echo "404 Not Found";
            break;
}
