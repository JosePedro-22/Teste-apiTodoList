<?php
namespace app\controllers;
use app\controllers\Controller;
use app\services\LoginService;

class Login extends Controller{
    
    private static $loginService;
    
    public function __construct()
    {
        parent::__construct();
        self::$loginService = new LoginService(self::$db);
    }

    public function store(array $body){
        if(!$body['email'] && $body['password']){
            http_response_code(401);
            echo json_encode(array('message' => 'Credenciais incorretas'));
        }

        if(self::$loginService->EmailExists($body['email']) && self::$loginService->PasswordEqual($body['email'], $body['password']))
                echo self::$loginService->CreateToken($body);
        else {
            http_response_code(401);
            echo json_encode(array('message' => 'Credenciais incorretas'));
        }
    }

    public static function verify(){

        $headers = getallheaders();
        if (isset($headers['authorization'])) {
            $token = str_replace("Bearer ", "", $headers['authorization']);
        } else if (isset($headers['Authorization'])) {
            $token = str_replace("Bearer ", "", $headers['Authorization']);
        } else {
            echo json_encode(['ERRO' => 'Você não está logado, ou seu token é inválido.']);
            exit;
        }

        echo self::$loginService->VerifyToken($token);
    }
}