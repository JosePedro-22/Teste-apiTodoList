<?php
namespace app\dao;
require_once "../app/models/User.php";
use app\models\User;
use app\models\UserDAO;
use PDO;



class UserDAOMysql implements UserDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }
    
    private function generateUser(array $array):User
    {
        $user = new User();

        $user->id = $array['id'] ?? 0;
        $user->name = $array['name'] ?? '';
        $user->email = $array['email'] ?? '';
        $user->password = $array['password'] ?? '';
    
        return $user;
    }
    
    public function insert(User $data):mixed
    {
        $sql = $this->pdo->prepare('INSERT INTO users 
            (name,email,password) 
            VALUES 
            (:name,:email,:password)');

        $sql->bindParam(':name',$data->name);
        $sql->bindParam(':email',$data->email);
        $sql->bindParam(':password',$data->password);
        $success = $sql->execute();

        if ($success) {
            $lastId = $this->pdo->lastInsertId();
            return $this->getUserById($lastId);
        } else {
            return false;
        }
    }

    public function update(User $data):array|bool
    {
        $sql = $this->pdo->prepare('UPDATE users SET 
            name = :name,
            email = :email,
            password = :password
            WHERE id = :id');
        
        $sql->bindParam(':id', $data->id);
        $sql->bindParam(':name', $data->name);
        $sql->bindParam(':email', $data->email);
        $sql->bindParam(':password', $data->password);
    
        $success = $sql->execute();

        if ($success && $sql->rowCount() > 0) {
            return $this->getUserById($data->id);
        } else {
            return false;
        }
    }

    public function delete(int $id):int|bool
    {
        $sql = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        
        $sql->bindParam(':id',$id);
        $success = $sql->execute();

        if ($success && $sql->rowCount() > 0) {
            return $id;
        } else {
            return false;
        }
            
    }

    public function findByEmail(string $email):User|bool
    {    
        if(!empty($email)){
            $sql = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
            $sql->bindParam(':email',$email);
            $sql->execute();
    
            $data = $sql->fetch(PDO::FETCH_ASSOC);
    
            if ($data) return $this->generateUser($data);
        }
    
        return false;
    }

    public function getUserById(int $userId):array|bool
    {
        $sql = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $sql->bindParam(':id', $userId);
        $sql->execute();
        
        $userData = $sql->fetch(PDO::FETCH_ASSOC);
        if ($userData) {
            return $userData;
        } else {
            return false;
        }
    }
}