<?php

namespace routes;

class web{

    private $method;
    private $controllerMethod;
    private $params = [];

    function __construct(){
        $url = $this->parseURL();
        $this->method = $_SERVER["REQUEST_METHOD"];
        $con = ucfirst($url[1]);
    
        if(file_exists("../app/controllers/" .$con. ".php")) unset($url[1]);
        elseif(empty($url[1]) && $this->method === 'GET'){
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
        $this->params = [];
    
        $requestData = json_decode(file_get_contents('php://input'), true);
        
        switch($this->method){
            case "GET":
                if(isset($url[2])){
                    $this->controllerMethod = "find";
                    $this->params = [$url[2]];
                }else $this->controllerMethod = "index";
                break;
    
            case "POST":
                $this->controllerMethod = "store";
                $this->params = [$requestData];
                break;
    
            case "PUT":
                $this->controllerMethod = "update";
                if(isset($url[3]) && is_numeric($url[3])) $this->params = [$url[3], $requestData];
                else{
                    http_response_code(400);
                    echo json_encode(["erro" => "É necessário informar um id"]);
                    exit;
                }
                break;
    
            case "DELETE":
                $this->controllerMethod = "delete";
                if(isset($url[3]) && is_numeric($url[3])) $this->params = [$url[3]];
                else{
                    http_response_code(400);
                    echo json_encode(["erro" => "É necessário informar um id"]);
                    exit;
                }
                break;
    
            default: 
                http_response_code(405);
                echo json_encode(["erro" => "Método não suportado"]);
                exit;
                break;
        }
        call_user_func_array([$controllerInstance, $this->controllerMethod], $this->params);
    }

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }
}