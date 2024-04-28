<?php
namespace app\models;

class Task {
    public $id;
    public $title;
    public $description;
    public $status;
    public $user_id;
}

interface TaskDAO{
    public function insert(Task $task):mixed;
    public function update(Task $task):Task|bool;
    public function delete(int $taskId):int|bool;
    public function findAll(int $idUser):array;
    public function findById(int $taskId):array;
}