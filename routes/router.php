<?php
require_once "../app/config/database.php";

$database = new Database();
$db = $database->getConnection();

function load(string $controller, string $action, PDO $db, $id = null){
    try{
        
        $controllerNamespace = "app\\controllers\\{$controller}";

        if(!class_exists($controllerNamespace))
            throw new Exception("Controller {$controller} not found");

        $controllerInstance = new $controllerNamespace($db);
    
        if(!method_exists($controllerInstance, $action))
            throw new Exception("Method {$action} in the '$controller' not allowed");

        if ($id !== null) {
            
            $controllerInstance->$action($id);
        } else {
            $controllerInstance->$action();
        }

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
    // "PUT" => [
    //     // "/edit/user" => fn() => load('UserController', 'update', $db),
    //     "/edit/user/{id}" => function() use ($db) {
    //         // Obtém o ID da URL
    //         $uri = parse_url($_SERVER["REQUEST_URI"])["path"];
    //         $parts = explode('/', $uri);
    //         $id = end($parts);

    //         // Verifica se o ID contém apenas números
    //         if (preg_match('/^\d+$/', $id)) {
    //             load('UserController', 'update', $db, $id);
    //         } else {
    //             http_response_code(400);
    //             echo json_encode(array('message' => 'Invalid ID format'));
    //         }
    //     },
    // ],
    // "DELETE" => [
    //     // "/delete/user/{id}" => fn() => load('UserController', 'delete', $db),
    //     "/delete/user/{id}" => function() use ($db) {
    //         // Obtém o ID da URL
    //         $uri = parse_url($_SERVER["REQUEST_URI"])["path"];
    //         $parts = explode('/', $uri);
    //         $id = end($parts);

    //         // Verifica se o ID contém apenas números
    //         if (preg_match('/^\d+$/', $id)) {
    //             load('UserController', 'delete', $db, $id);
    //         } else {
    //             http_response_code(400);
    //             echo json_encode(array('message' => 'Invalid ID format'));
    //         }
    //     },
    // ],
    "PUT" => [
        "/edit/user/{id}" => function($id) use ($db) {
            load('UserController', 'update', $db, $id);
        },
    ],
    "DELETE" => [
        "/delete/user/{id}" => function($id) use ($db) {
            load('UserController', 'delete', $db, $id);
        },
    ],
];