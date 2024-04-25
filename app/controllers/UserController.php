<?php
namespace app\controllers;

require_once __DIR__ . "/../services/UserService.php";
require_once __DIR__ . "/../config/database.php";
use app\services\UserService;
use PDO;

class UserController
{
    public $user;
    public $db;

    public function __construct(PDO $driver)
    {
        $this->db = $driver;
    }
    
    public function index()
    {
        echo "Home";
    }
    
    public function store(){
        
        $name = filter_input(INPUT_POST,'name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST,'password');

        $userService = new UserService($this->db);

        $userService->NewUser($name, $email, $password);
    }

    public function update(){
        echo "update";
    }

    public function delete(){
        echo "delete";
    }
}