<?php
namespace app\models;

class User{
    public $id;
    public $name;
    public $email;
    public $password;
    public $createdAt;
    public $updatedAt;
    public $token;
}

interface UserDAO{
    public function insert(User $user):mixed;
    public function update(User $user):array|bool;
    public function delete(int $id):int|bool;
    public function findByEmail(string $email):User|bool;
    public function getUserById(int $id):array|bool;
}