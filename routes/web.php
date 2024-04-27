<?php

namespace routes;

use app\config\Middleware;
use app\controllers\Login;

class Web {

    private $params = [];
    private $controllerMethod;

    function __construct(){
        $url = $this->parseURL();
        $method = $_SERVER["REQUEST_METHOD"];
        $con = ucfirst($url[1]);
        
        if ($con !== 'User' && !($con === 'Login' && $method === 'POST'))
            Login::verify();
        else $this->callTheRouter($con, $url, $method);
    }

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }

    private function callTheRouter(string $con, array $url, string $method){
        if(file_exists("../app/controllers/" .$con. ".php")) 
            unset($url[1]);
        elseif(empty($url[1]) && $method === 'GET'){
            http_response_code(200);
            echo json_encode(["message" => "Bem-Vindo ApiREST ToDo List"]);
            exit;
        }else{
            http_response_code(404);
            echo json_encode(["erro" => "Recurso não encontrado"]);
            exit;
        }
            
        $controllerNamespace = "app\\controllers\\{$con}";
        $controllerInstance = new $controllerNamespace();

        $validatedRoute = Middleware::handle($method, $url, $con, json_decode(file_get_contents('php://input'), true), $this->params);
        
        $this->controllerMethod = $validatedRoute['controllerMethod'];
        $this->params = $validatedRoute['params'];
        
        call_user_func_array([$controllerInstance, $this->controllerMethod], $this->params);
    }
}