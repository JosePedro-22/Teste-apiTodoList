<?php
namespace app\services;
use app\dao\UserDaoMysql;
use PDO;
use User;

require_once "../app/config/database.php";

class UserService{
    
    public $driver;
    public $UserDao;
    
    public function __construct(PDO $db)
    {  
        $this->driver = $db;
    }

    public function NewUser(string $name, string $email, string $password){
        $user = new User();
        $UserDao = new UserDaoMysql($this->driver);

        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $user->name = $name;
        $user->email = $email;
        $user->password = $hash;

        $UserDao->insert($user);
        echo "{$name} {$email} {$hash}";

    }
}