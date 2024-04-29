<?php
namespace app\services;

use app\dao\TaskDAOMysql;
use app\models\TaskModel;
use PDO;

class TaskService {
    private $taskDao;

    public function __construct(PDO $db)
    {  
        $this->taskDao = new TaskDAOMysql($db);
    }

    public function getAllTasks(int $id): array
    {
        return $this->taskDao->findAll($id);
    }

    public function getByIdTask(int $id): array
    {
        return $this->taskDao->findById($id);
    }

    public function newTask($data, int $id): mixed
    {
        $task = $this->createTaskObject($data, null,$id);
        return $this->taskDao->insert($task);
    }

    public function updateTask(int $id, array $data): TaskModel|bool|array
    {
        $task = $this->createTaskObject($data, $id, null);
        return $this->taskDao->update($task);
    }

    public function deleteTask(int $id):int|bool
    {
        return $this->taskDao->delete($id);
    }

    public function taskExists($id): array
    {
        return $this->taskDao->findById($id);
    }

    private function createTaskObject(array $data, int $id = null, int $user_id = null): TaskModel 
    {
        $task = new TaskModel();

        $task->id = $id;
        $task->title = $this->sanitizeString($data['title']);
        $task->description = $this->sanitizeString($data['description']);
        
        if(isset($data['status']) && ($data['status'] === true || $data['status'] === 1)){
            $task->status = 1;
        }
        else {
            $task->status = 0;
        }
        $task->user_id = $user_id;

        return $task;
    }

    private function sanitizeString(string $value): string 
    {
        return htmlspecialchars($value);
    }
}
