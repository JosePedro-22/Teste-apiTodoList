<?php
namespace app\models;
class User{
    public $id;
    public $name;
    public $email;
    public $password;
}

interface UserDAO{
    public function insert(User $user);
    public function update(User $user);
    public function delete(int $user);
    public function findByEmail(string $user);
    public function getUserById(int $id);
}