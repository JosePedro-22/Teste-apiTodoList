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

    public function newUser(array $data):mixed
    {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $this->user->name = addslashes(htmlspecialchars($data['name']));
        $this->user->email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $this->user->password = $hash;

        return $this->userDao->insert($this->user);
    }

    public function updateUser(int $id, array $data):array|bool
    {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->user->id = $id;
        $this->user->name = addslashes(htmlspecialchars($data['name']));
        $this->user->email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $this->user->password = $hash;

        return $this->userDao->update($this->user);
    }

    public function deleteUser(int $id):int|bool
    {
        return $this->userDao->delete($id);
    }

    public function emailExists(string $email):User|bool
    {
        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $this->userDao->findByEmail($this->user->email) ? true :  false;
    }

    public function userExists($id):array|bool
    {
        return $this->userDao->getUserById($id);
    }
    
}