<?php
namespace app\interfaces;

use app\models\UserModel;

interface InterfaceLoginDAO{
    public function findByEmail(string $email): UserModel|bool;
    public function saveToken(string $email, string $token):bool;
    public function updateToken(string $token):array|bool;
}