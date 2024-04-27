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
    public function insert(Task $task);
    public function update(Task $task);
    public function delete(int $taskId);
    public function findAll(int $idUser);
    public function findById(int $taskId);
}