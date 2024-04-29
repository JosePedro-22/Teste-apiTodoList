<?php
namespace app\interfaces;

use app\models\TaskModel;

interface InterfaceTaskDAO{
    public function insert(TaskModel $task):mixed;
    public function update(TaskModel $task):TaskModel|bool|array;
    public function delete(int $taskId):int|bool;
    public function findAll(int $idUser):array;
    public function findById(int $taskId):array;
}