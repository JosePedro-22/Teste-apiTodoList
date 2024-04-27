<?php
namespace app\dao;

use app\models\User as ModelsUser;
use app\models\UserDAO as ModelsUserDAO;
use Firebase\JWT\JWT;
use PDO;

require_once "../app/models/User.php";

class UserDaoMysql implements ModelsUserDAO{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }
    
    private function generateUser(array $array){
        $user = new ModelsUser();

        $user->id = $array['id'] ?? 0;
        $user->name = $array['name'] ?? '';
        $user->email = $array['email'] ?? '';
        $user->password = $array['password'] ?? '';
    
        return $user;
    }
    
    public function insert(ModelsUser $data){
        $sql = $this->pdo->prepare('INSERT INTO usuarios 
            (name,email,password) 
            VALUES 
            (:name,:email,:password)');

        $sql->bindParam(':name',$data->name);
        $sql->bindParam(':email',$data->email);
        $sql->bindParam(':password',$data->password);
        $sql->execute();
        
        if ($sql->rowCount() > 0) return $this->findByEmail($data->email);
        else return false;
    }

    public function update(ModelsUser $data){

        $sql = $this->pdo->prepare('UPDATE usuarios SET 
            name = :name,
            email = :email,
            password = :password
            WHERE id = :id');
        
        $sql->bindParam(':id', $data->id);
        $sql->bindParam(':name', $data->name);
        $sql->bindParam(':email', $data->email);
        $sql->bindParam(':password', $data->password);
    
        $sql->execute();
        
        if ($sql->rowCount() > 0) return $this->findByEmail($data->email);
        else return false;
    }

    public function delete(int $id){
        $sql = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        
        $sql->bindParam(':id',$id);
        $sql->execute();

        if ($sql->rowCount() > 0) return $id;
        else return false;
            
    }

    public function findByEmail(string $email){
        
        if(!empty($email)){
            $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
            $sql->bindParam(':email',$email);
            $sql->execute();

            $data = $sql->fetch(PDO::FETCH_ASSOC);

            if ($data) return $this->generateUser($data);
        }

        return false;
    }

    public function getUserById(int $userId) {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
        $sql->bindParam(':id', $userId);
        $sql->execute();
        
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function saveToken(string $email, string $token){
        $data = $this->findByEmail($email);

        if(!empty($data)){
            $sql = $this->pdo->prepare('UPDATE usuarios SET 
            token = :token
            WHERE id = :id');
            
            $sql->bindParam(':id', $data->id);
            $sql->bindParam(':token', $token);
        
            $sql->execute();
        
            if ($sql->rowCount() > 0) return true;
        }
        return false;
    }

    public function updateToken(string $token){

        if(!empty($token)){
            $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE token = :token');
            $sql->bindParam(':token',$token);
            $sql->execute();

            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $decodedJWT = JWT::decode($data['token'], $GLOBALS['secretJWT']);

            if ($decodedJWT->expires_in > time()) return true;
            else {
                
                $this->pdo->prepare("UPDATE usuarios SET token = '' WHERE id = :token");
                $sql->bindParam(':token',$token);
                $sql->execute();

                return false;
            }
        }

        return false;
    }
}