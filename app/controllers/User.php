<?php
namespace app\controllers;
use app\controllers\Controller as Controller;
use app\services\UserService;

class User extends Controller
{
    public $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService(self::$db);
    }
    
    public function index()
    {
        http_response_code(200);
        echo json_encode(["message" => "Bem-Vindo ApiREST ToDo List"]);
    }

    public function find()
    {
        http_response_code(200);
        echo json_encode(["message" => "Nenhuma Task cadastrada na ApiREST ToDo List"]);
    }
    
    public function store(array $body){
        if($body['email'] && $body['password']){
            if($this->userService->EmailExists($body['email']) === false)
                echo json_encode(array($this->userService->NewUser($body)));
            else {
                http_response_code(404);
                echo json_encode(array('message' => 'Usuario já existe'));
            }
        }else{
            http_response_code(404);
            echo json_encode(array('message' => 'Email ou Password incorreto'));
            exit;
        }
        
    }

    public function update($id, array $body){
        if($id && $body['email']){
            if($this->userService->EmailExists($body['email']) === false){
                $result = $this->userService->UpdateUser($id,$body);
                if($result) echo json_encode(array('message' => 'Usuário atualizado com sucesso'));
                 else {
                    http_response_code(500);
                    echo json_encode(array('message' => 'Falha ao atualizar o Usuário'));
                }
            }else {
                http_response_code(400);
                echo json_encode(array('message' => 'E-mail já existe'));
                exit;
            }
        }else{
            http_response_code(400);
            echo json_encode(array('message' => 'Dados de Usuário inválidos'));
            exit;
        }
    }

    public function delete($id){
        if(!$id){
            http_response_code(404);
            echo json_encode(array('message' => 'Invalid user ID'));
            exit;
        }

        if($this->userService->UserExists($id)){ 
            if($this->userService->DeleteUser($id)){
                echo json_encode(array('message' => 'Usuário excluído com sucesso'));
            } else {
                http_response_code(500);
                echo json_encode(array('message' => 'Falha ao excluir Usuário'));
            }
        } else {
            http_response_code(404);
            echo json_encode(array('message' => 'Usuário não encontrado'));
        }
    }
}