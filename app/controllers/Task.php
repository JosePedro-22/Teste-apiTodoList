<?php
namespace app\controllers;

use app\models\UserModel;
use app\models\TaskModel;
use app\services\TaskService;
use Exception;

class Task extends Controller {
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserModel();
    }
    
    public function index($params,$user): void
    {
        if(is_array($user)) $this->user->id = $user['id'];
            else $this->user->id = $user->id;

        $data = (new TaskService(self::$db))->getAllTasks($this->user->id);
        if (empty($data)) {
            http_response_code(404);
            echo json_encode(["message" => "O Usuario não possui nenhuma Task"]);
        } else {
            http_response_code(200);
            echo json_encode($data);
        }
    }

    public function find($params,$user): void
    {   
        $data = (new TaskService(self::$db))->getByIdTask($params[0]);
        if (empty($data)) {
            http_response_code(404);
            echo json_encode(["message" => "Não existe nenhuma Task"]);
        } else {
            echo json_encode($data);
        }
    }
    
    public function store(array $body, array $user): void
    {
        if(!(isset($body[0]['title']) && strlen($body[0]['title']) >= 3) || !(isset($body[0]['description']) && strlen($body[0]['description']) >= 3)) {
            http_response_code(404);
            echo json_encode(["message" => "Titulo ou Descricao invalidos"]);
        }else {
            echo json_encode((new TaskService(self::$db))->newTask($body[0], $user['id']));
        }
    }

    public function update(array $body, array $user): void
    {        
        if((isset($body[1]['title']) && strlen($body[1]['title']) >= 3) && (isset($body[1]['description']) && strlen($body[1]['description']) >= 3)){
            http_response_code(200);
            echo json_encode((new TaskService(self::$db))->updateTask($body[0], $body[1]));
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Titulo ou Descricao invalidos"]);
        }
    }

    public function delete(array $body, array $user): void
    {
        if (!$body[0] || !(new TaskService(self::$db))->taskExists($body[0])) {
            http_response_code(404);
            echo json_encode(["message" => "Task não encontrado"]);
        }else {
            if ((new TaskService(self::$db))->deleteTask($body[0])) {
                echo json_encode(array('message' => 'Task excluída com sucesso'));
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Falha ao excluir Task"]);
            }
        }
       
    }
}