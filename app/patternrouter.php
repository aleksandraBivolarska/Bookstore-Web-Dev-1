<?php
//class PatternRouter {
//     private function stripParameters($uri){
//         if (str_contains($uri, '?')) {
//             $uri = substr($uri, 0, strpos($uri, '?'));
//         }
//         return $uri;
//     }


//     public function route($uri){
//         //check if it's an api route
//         $api = false;
//         if (str_starts_with($uri, "api/")) {
//             $uri = substr($uri, 4);
//             $api = true;
//         }

//         //setting default controller and method (home)
//         $defaultcontroller = 'login';
//         $defaultmethod = 'index';

//         //ignore query parameters
//         $uri = $this->stripParameters($uri);

//         //separate uri controller/method from string
//         $explodedUri = explode('/', $uri);

//         //default cases and setting controller/method names
//         if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
//             $explodedUri[0] = $defaultcontroller;
//         }
//         $controllerName = $explodedUri[0] . "controller";

//         if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
//             $explodedUri[1] = $defaultmethod;
//         }
//         $methodName = $explodedUri[1];

//         //load the file with controller
//         $filename = __DIR__ . '/controllers/' . $controllerName . '.php'; //getting controller file
//         if ($api) {
//             $filename = __DIR__ . '/api/controllers/' . $controllerName . '.php';
//         }

//         if (file_exists($filename)) {
//             require $filename;
//         }
//         else {
//             //http_response_code(404);
//             die();
//         }

//         //and call for dynamic controller method
//         try {
//             $controllerObj = new $controllerName;
//             $controllerObj->{$methodName}();
//         }
//         catch (Exception $e) {
//             echo $e;
//             //http_response_code(404);
//             die();
//         }
//     }
// }




?>