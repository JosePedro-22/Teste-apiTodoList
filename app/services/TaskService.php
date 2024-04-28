<?php
namespace app\services;

use app\dao\TaskDAOMysql;
use app\models\Task;
use PDO;

class TaskService {
    public $driver;
    public $taskDao;
    public $task;

    public function __construct(PDO $db)
    {  
        $this->driver = $db;
        $this->taskDao = new TaskDAOMysql($this->driver);
        $this->task = new Task();
    }
    public function getAllTasks(int $id){
        return $this->taskDao->findAll($id);
    }
    public function getByIdTask(int $id){
        return $this->taskDao->findById($id);
    }
    public function newTask(array $data, int $id){
        
        $this->task->title = addslashes(htmlspecialchars($data['title']));
        $this->task->description = addslashes(htmlspecialchars($data['description']));
        if(isset($data['status']) && ($data['status'] === true || $data['status'] === false))
            $this->task->status = $data['status'];
        else $this->task->status = 0;
        $this->task->user_id = $id;

        return $this->taskDao->insert($this->task);
    }

    public function updateTask(int $id, array $data){

        $this->task->id = $id;
        $this->task->title = addslashes(htmlspecialchars($data['title']));
        $this->task->description = addslashes(htmlspecialchars($data['description']));
        if(isset($data['status']) && ($data['status'] === true || $data['status'] === false))
            $this->task->status = $data['status'];
        else $this->task->status = 0;

        return $this->taskDao->update($this->task);
    }

    public function deleteTask(int $id){
        return $this->taskDao->delete($id);
    }

    public function taskExists($id){
        return $this->taskDao->findById($id);
    }
}