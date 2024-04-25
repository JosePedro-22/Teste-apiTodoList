<?php
require_once "../app/config/database.php";

$database = new Database();
$db = $database->getConnection();

function load(string $controller, string $action, PDO $db){
    
    try{

        $controllerNamespace = "app\\controllers\\{$controller}";

        if(!class_exists($controllerNamespace))
            throw new Exception("Controller {$controller} not found");

        $controllerInstance = new $controllerNamespace($db);
    
        if(!method_exists($controllerInstance, $action))
            throw new Exception("The method {$action} in the '$controller' not found");

        $controllerInstance->$action();
    }catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }

}

$routes = [
    "GET" => [
        "/" => fn() => load('UserController', 'index', $db),
    ],
    "POST" => [
        "/register/user" => fn() => load('UserController', 'store', $db),
    ],
    "PUT" => [
        "/edit/user" => fn() => load('UserController', 'update', $db),
    ],
    "DELETE" => [
        "/delete/user" => fn() => load('UserController', 'delete', $db),
    ],
];