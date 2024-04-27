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
    public function insert(User $user);
    public function update(User $user);
    public function delete(int $id);
    public function findByEmail(string $email);
    public function getUserById(int $id);
}