<?php
namespace app\controllers;

use app\models\User;
use app\services\TaskService;

class Task extends Controller {
    public $taskService;
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->taskService = new TaskService(self::$db);
        $this->user = new User();
    }
    
    public function index(array $params,array $user){
        $data = $this->taskService->getAllTasks($user['id']);
        if(empty($data)){
            http_response_code(404);
            echo json_encode(array('message' => 'O Usuario não possui nenhuma Task'));
        }else  echo json_encode($data);
    }

    public function find(array $params,array $user)
    {   
        $data = $this->taskService->getByIdTask($params[0]);
        if(empty($data)){
            http_response_code(404);
            echo json_encode(array('message' => 'Não existe nenhuma Task'));
        }else  echo json_encode($data);
    }
    
    public function store(array $body, array $user){
        if($body[0]['title'] && $body[0]['description']){
            echo json_encode($this->taskService->newTask($body[0], $user['id']));
        }else{
            http_response_code(404);
            echo json_encode(array('message' => 'Titulo ou Descricao invalidos'));
        }
        
    }

    public function update(array $body, array $user){
        if($body[1]['title'] && $body[1]['description']){
            echo json_encode($this->taskService->updateTask($body[0], $body[1]));
        }else{
            http_response_code(400);
            echo json_encode(array('message' => 'Titulo ou Descricao invalidos'));
            exit;
        }
    }

    public function delete(array $body, array $user){
        if(!$body[0]){
            http_response_code(404);
            echo json_encode(array('message' => 'Invalid user ID'));
            exit;
        }
        
        if(!$this->taskService->taskExists($body[0])){ 
            http_response_code(404);
            echo json_encode(array('message' => 'Task não encontrado'));
        }

        if($this->taskService->deleteTask($body[0])){
            echo json_encode(array('message' => 'Task excluída com sucesso'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Falha ao excluir Task'));
        }
    }
}