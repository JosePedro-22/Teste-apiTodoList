<?php
namespace app\controllers;
use app\controllers\Controller as Controller;
use app\services\UserService;
use Exception;

class User extends Controller
{
    public $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService(self::$db);
    }
    
    public function index():void
    {
        try {
            http_response_code(200);
            echo json_encode(["message" => "Bem-Vindo ApiREST ToDo List"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function find():void
    {
        try {
            http_response_code(200);
            echo json_encode(["message" => "Nenhuma Task cadastrada na ApiREST ToDo List"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    public function store(array $body):void
    {
        try {
            if(isset($body[0]['email']) && isset($body[0]['password'])){
                if($this->userService->emailExists($body[0]['email']) === false)
                    echo json_encode($this->userService->newUser($body[0]));
                else {
                    http_response_code(404);
                    echo json_encode(array('message' => 'Usuario já existe'));
                }
            }else{
                http_response_code(404);
                echo json_encode(array('message' => 'Email ou Password incorreto'));
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function update(array $body):void
    {
        try {
            if($body[0] && $body[1]['email']){
                if($this->userService->emailExists($body[1]['email']) === false){
                    $result = $this->userService->updateUser($body[0],$body[1]);
                    if($result) echo json_encode(array('message' => 'Usuário atualizado com sucesso'));
                    else {
                        http_response_code(500);
                        echo json_encode(array('message' => 'Falha ao atualizar o Usuário'));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array('message' => 'E-mail já existe'));
                    exit;
                }
            } else {
                http_response_code(400);
                echo json_encode(array('message' => 'Dados de Usuário inválidos'));
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }

    }

    public function delete(array $user): void
    {
        try {
            if(!$user[0]){
                http_response_code(404);
                echo json_encode(array('message' => 'Invalid user ID'));
            }

            if($this->userService->userExists($user[0])){ 
                if($this->userService->deleteUser($user[0])){
                    echo json_encode(array('message' => 'Usuário excluído com sucesso'));
                } else {
                    http_response_code(500);
                    echo json_encode(array('message' => 'Falha ao excluir Usuário'));
                }
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'Usuário não encontrado'));
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}