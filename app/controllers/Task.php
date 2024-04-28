<?php
namespace app\controllers;

use app\models\User;
use app\services\TaskService;
use Exception;

class Task extends Controller {
    public $taskService;
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->taskService = new TaskService(self::$db);
        $this->user = new User();
    }
    
    public function index(array $params,array $user): void
    {
        try {
            $data = $this->taskService->getAllTasks($user['id']);
            if (empty($data)) {
                throw new Exception('O Usuario não possui nenhuma Task', 404);
            } else {
                echo json_encode($data);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    public function find(array $params,array $user): void
    {   
        try {
            $data = $this->taskService->getByIdTask($params[0]);
            if (empty($data)) {
                throw new Exception('Não existe nenhuma Task', 404);
            } else {
                echo json_encode($data);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo json_encode(['message' => $e->getMessage()]);
        }
    }
    
    public function store(array $body, array $user): void
    {
        try {
            if(!(isset($body[0]['title']) && strlen($body[0]['title']) >= 3) || !(isset($body[0]['description']) && strlen($body[0]['description']) >= 3)) {
                throw new Exception('Titulo ou Descricao invalidos');
            }
    
            echo json_encode($this->taskService->newTask($body[0], $user['id']));
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    public function update(array $body, array $user): void
    {
        try {
            if((isset($body[1]['title']) && strlen($body[1]['title']) >= 3) && (isset($body[1]['description']) && strlen($body[1]['description']) >= 3)){
                echo json_encode($this->taskService->updateTask($body[0], $body[1]));
            } else {
                throw new Exception('Titulo ou Descricao invalidos');
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('message' => $e->getMessage()));
        }
    }

    public function delete(array $body, array $user): void
    {
        try {
    
            if (!$body[0] || !$this->taskService->taskExists($body[0])) {
                throw new Exception('Task não encontrado');
            }
    
            if ($this->taskService->deleteTask($body[0])) {
                echo json_encode(array('message' => 'Task excluída com sucesso'));
            } else {
                throw new Exception('Falha ao excluir Task');
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array('message' => $e->getMessage()));
        }
    }
}