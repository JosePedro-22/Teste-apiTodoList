<?php
namespace app\controllers;
use app\controllers\Controller;
use app\services\LoginService;

class Login extends Controller{
    
    private static ?LoginService $loginService = null;
    
    public function __construct()
    {
        parent::__construct();
        self::$loginService = new LoginService(self::$db);
    }

    public function store(array $body){
        if(!$body[0]['email'] && $body[0]['password']){
            http_response_code(401);
            echo json_encode(array('message' => 'Credenciais incorretas'));
        }

        if(self::$loginService->emailExists($body[0]['email']) && self::$loginService->passwordEqual($body[0]['email'], $body[0]['password'])){
            echo self::$loginService->createToken($body[0]);
        }
        else {
            http_response_code(401);
            echo json_encode(array('message' => 'Credenciais incorretas'));
        }
    }

    public static function verify(){
        $headers = getallheaders();
        
        if (isset($headers['Authorization'])) {
            $token = str_replace("Bearer ", "", $headers['Authorization']);
            $data = self::$loginService->verifyToken($token);
            if(self::$loginService->verifyToken($token)) return $data;
            else echo json_encode(['ERRO' => 'Você não está logado, ou seu token é inválido.']);
        }
        else {
            http_response_code(404);
            echo json_encode(['ERRO' => 'Você não está logado, ou seu token é inválido.']);
        }
        
        
    }
}