<?php
namespace app\interfaces;

use app\models\UserModel;

interface InterfaceUserDAO{
    public function insert(UserModel $user):mixed;
    public function update(UserModel $user):array|bool;
    public function delete(int $id):int|bool;
    public function findByEmail(string $email):UserModel|bool;
    public function getUserById(int $id):array|bool;
}