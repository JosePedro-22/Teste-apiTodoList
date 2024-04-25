<?php

class Task {
    public $id;
    public $title;
    public $description;
    public $status;
    public $createdAt;
    public $updatedAt;
}

interface TaskDAO{
    // public function findByToken($token);
    // public function findByEmail($email);
    // public function findById($id, $full = false);
    // public function update(User $user);
    // public function insert(User $user);
}