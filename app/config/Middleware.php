<?php
namespace app\config;

class Middleware {

    public static function handle($method, $url, $con, $requestData, $params) {
        switch($method) {
            case "GET":
                if (!empty($url[2])) {
                    $controllerMethod = "find";
                    $params = [$url[2]];
                } else {
                    $controllerMethod = "index";
                }
                break;

            case "POST":
                if (!empty($url[2]) || !$con === 'Login' && ($con === 'Login' && empty($url[3]))) {
                    http_response_code(405);
                    echo json_encode(["erro" => "Método não suportado"]);
                    exit;
                }
                $controllerMethod = "store";
                $params = [$requestData];
                break;

            case "PUT":
                $controllerMethod = "update";
                if (isset($url[3]) && is_numeric($url[3])) {
                    $params = [$url[3], $requestData];
                } else {
                    http_response_code(400);
                    echo json_encode(["erro" => "É necessário informar um id"]);
                    exit;
                }
                break;

            case "DELETE":
                $controllerMethod = "delete";
                if (isset($url[3]) && is_numeric($url[3])) {
                    $params = [$url[3]];
                } else {
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

        return [
            'controllerMethod' => $controllerMethod,
            'params' => $params
        ];
    }
}