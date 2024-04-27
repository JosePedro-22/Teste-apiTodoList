<?php
namespace app\services;
use app\dao\UserDAOMysql;
use PDO;
use app\models\User;

class UserService{
    
    public $driver;
    public $userDao;
    public $user;

    public function __construct(PDO $db)
    {  
        $this->driver = $db;
        $this->userDao = new UserDAOMysql($this->driver);
        $this->user = new User();
    }

    public function newUser(array $data){
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $this->user->name = addslashes(htmlspecialchars($data['name']));
        $this->user->email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $this->user->password = $hash;

        return $this->userDao->insert($this->user);
    }

    public function updateUser(int $id, array $data){
        
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->user->id = $id;
        $this->user->name = addslashes(htmlspecialchars($data['name']));
        $this->user->email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $this->user->password = $hash;

        return $this->userDao->update($this->user);
    }

    public function deleteUser(int $id){
        return $this->userDao->delete($id);
    }

    public function emailExists(string $email){
        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $this->userDao->findByEmail($this->user->email) ? true :  false;
    }

    public function userExists($id){
        return $this->userDao->getUserById($id);
    }
    
}