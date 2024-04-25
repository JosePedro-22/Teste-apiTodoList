<?php
header('Content-Type: application/json');

require "./vendor/autoload.php";
require "./app/models/User.php";
require "./app/controllers/UserController.php";
require "./routes/router.php";

try{
    $uri = parse_url($_SERVER["REQUEST_URI"])["path"];
    $request = $_SERVER["REQUEST_METHOD"];

    if(!isset($routes[$request]))
        throw new Exception("Route not found");
    
    if(!array_key_exists($uri, $routes[$request]))
        throw new Exception("Route not found");

    $controller = $routes[$request][$uri];
    
    $controller();

}catch(Exception $e){
    http_response_code(405);
    echo json_encode(array('message' => 'Method or Controller not allowed.'));
}