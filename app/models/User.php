<?php

class User{
    public $id;
    public $name;
    public $email;
    public $password;
}

interface UserDAO{
    public function insert(User $user);
    public function update(User $user);
    public function delete(User $user);
}