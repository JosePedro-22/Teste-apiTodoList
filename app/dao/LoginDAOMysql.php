<?php
namespace app\dao;
require_once "../app/models/User.php";
use app\models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;

class LoginDAOMysql{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }
    
    private function generateUser(array $array): User
    {
        $user = new User();

        $user->id = $array['id'] ?? 0;
        $user->name = $array['name'] ?? '';
        $user->email = $array['email'] ?? '';
        $user->password = $array['password'] ?? '';
    
        return $user;
    }
    
    public function findByEmail(string $email): User|bool
    {
        
        if(!empty($email)){
            $sql = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
            $sql->bindParam(':email',$email);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                return $this->generateUser($data);
            }
        }

        return false;
    }

    public function saveToken(string $email, string $token):bool
    {
        $data = $this->findByEmail($email);

        if(!empty($data)){
            $sql = $this->pdo->prepare('UPDATE users SET 
            token = :token
            WHERE id = :id');
            
            $sql->bindParam(':id', $data->id);
            $sql->bindParam(':token', $token);
        
            $sql->execute();
        
            if ($sql->rowCount() > 0) return true;
        }
        return false;
    }

    public function updateToken(string $token):array|bool
    {
        
        $sql = $this->pdo->prepare('SELECT * FROM users WHERE token = :token');
        $sql->bindParam(':token',$token);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $decodedJWT = JWT::decode($data['token'], new Key($_ENV['KEY'], 'HS256'));
                
            if ($decodedJWT->exp > time()) return $data;
            else {
                
                $this->pdo->prepare("UPDATE users SET token = '' WHERE id = :token");
                $sql->bindParam(':token',$token);
                $sql->execute();

                return false;
            }
        } else return false;
    }
}