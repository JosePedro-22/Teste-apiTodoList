<?php
namespace app\dao;

use app\interfaces\InterfaceTaskDAO;
use PDO;
use app\models\TaskModel;

class TaskDAOMysql implements InterfaceTaskDAO{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert(TaskModel $data): mixed
    {
        if(empty($data->status) || $data->status === false || $data->status == 0){
            $data->status = 0;
        }else {
            $data->status = 1;
        }

        $sql = $this->pdo->prepare('INSERT INTO tasks 
            (title, description, status, user_id) 
            VALUES 
            (:title, :description, :status, :user_id)');

        $sql->bindParam(':title', $data->title);
        $sql->bindParam(':description', $data->description);
        $sql->bindParam(':status', $data->status);
        $sql->bindParam(':user_id', $data->user_id);
        $success = $sql->execute();

        if ($success) {
            $lastId = $this->pdo->lastInsertId();
            return $this->findById($lastId);
        } else {
            return false;
        }
    }

    public function update(TaskModel $data): TaskModel|bool|array
    {
        $sql = $this->pdo->prepare('UPDATE tasks SET 
            title = :title,
            description = :description,
            status = :status
            WHERE id = :id');

        $sql->bindParam(':id', $data->id);
        $sql->bindParam(':title', $data->title);
        $sql->bindParam(':description', $data->description);
        $sql->bindParam(':status', $data->status);

        $success = $sql->execute();

        if ($success) {
            return $this->findById($data->id);
        } else {
            return false;
        }
    }

    public function delete(int $id):int|bool
    {
        $sql = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id');
        $sql->bindParam(':id', $id);
        $success = $sql->execute();

        if ($success && $sql->rowCount() > 0) {
            return $id;
        } else {
            return false;
        }
    }

    public function findAll(int $userId):array
    {

        $sql = $this->pdo->prepare('SELECT * FROM tasks WHERE user_id = :userId');
        $sql->bindParam(':userId', $userId, PDO::PARAM_INT);
        $success = $sql->execute();

        if ($success) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function findById(int $taskId):array
    {
        $sql = $this->pdo->prepare('SELECT * FROM tasks WHERE id = :taskId');
        $sql->bindParam(':taskId', $taskId);
        $success = $sql->execute();

        if ($success && $sql->rowCount() > 0) {
            return $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
}