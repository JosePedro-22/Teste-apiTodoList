<?php
namespace app\services;
use app\dao\UserDaoMysql;
use PDO;
use app\models\User as ModelsUser;

class UserService{
    
    public $driver;
    public $userDao;
    public $user;
    public function __construct(PDO $db)
    {  
        $this->driver = $db;
        $this->userDao = new UserDaoMysql($this->driver);
        $this->user = new ModelsUser();
    }

    public function NewUser(array $data){
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $this->user->name = filter_var($data['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->user->email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $this->user->password = $hash;

        return $this->userDao->insert($this->user);
    }

    public function UpdateUser(int $id, array $data){
        
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->user->id = $id;
        $this->user->name = filter_var($data['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->user->email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $this->user->password = $hash;

        return $this->userDao->update($this->user);
    }

    public function DeleteUser(int $id){
        return $this->userDao->delete($id);
    }

    public function EmailExists(string $email){
        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $this->userDao->findByEmail($this->user->email) ? true :  false;
    }

    public function UserExists($id){
        return $this->userDao->getUserById($id);
    }
    
}