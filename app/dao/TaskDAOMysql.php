<?php
namespace app\dao;
require_once "../app/models/Task.php";

use app\models\Task;
use app\models\TaskDAO;
use PDO;

class TaskDAOMysql implements TaskDAO {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insert(Task $data) {
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

    public function update(Task $data) {
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

        if ($success && $sql->rowCount() > 0) {
            return $this->findById($data->id);
        } else {
            return false;
        }
    }

    public function delete(int $id) {
        $sql = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id');
        $sql->bindParam(':id', $id);
        $success = $sql->execute();

        if ($success && $sql->rowCount() > 0) {
            return $id;
        } else {
            return false;
        }
    }

    public function findAll(int $userId) {
        $sql = $this->pdo->prepare('SELECT * FROM tasks WHERE user_id = :userId');
        $sql->bindParam(':userId', $userId, PDO::PARAM_INT);
        $success = $sql->execute();

        if ($success) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function findById(int $taskId) {
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