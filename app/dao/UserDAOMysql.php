<?php
namespace app\dao;
use PDO;
use User;
use UserDAO;

require_once "./app/models/User.php";

class UserDaoMysql implements UserDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }
    
    public function insert(User $user){
        $sql = $this->pdo->prepare('INSERT INTO usuarios (name,email,password) VALUES (:name,:email,:password)');

        $sql->bindParam(':name',$user->name);
        $sql->bindParam(':email',$user->email);
        $sql->bindParam(':password',$user->password);
        $sql->execute();
        
        return true;
    }

    public function update(User $user){
        $sql = $this->pdo->prepare('UPDATE usuarios SET 
            name = :name,
            email = :email,
            password = :password,
            WHERE id = :id');
        
        $sql->bindParam(':id',$user->id);
        $sql->bindParam(':name',$user->name);
        $sql->bindParam(':email',$user->email);
        $sql->bindParam(':password',$user->password);
    
        $sql->execute();

        return true;
    }

    public function delete(User $user){
        $sql = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        
        $sql->bindParam(':id',$user->id);
        $sql->execute();

        return true;
    }  
}