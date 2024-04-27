<?php
namespace app\services;

use app\dao\LoginDAOMysql;
use PDO;
use app\models\User;
use Dotenv\Dotenv as Dotenv;
use Firebase\JWT\JWT;

class LoginService{
    public $driver;
    public $LoginDao;
    public $user;
    public function __construct(PDO $db)
    {  
        $this->driver = $db;
        $this->LoginDao = new LoginDAOMysql($this->driver);
        $this->user = new User();
        $dotenv = Dotenv::createImmutable(__DIR__."../../.."); 
        $dotenv->load();
    }

    public function emailExists(string $email){
        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $this->LoginDao->findByEmail($this->user->email) ? true :  false;
    }

    public function passwordEqual(string $email, string $password){

        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $user = $this->LoginDao->findByEmail($this->user->email);
        return password_verify($password, $user->password);
    }

    public function createToken(array $data){

        $payload = [
            'exp' => time() + 60000,
            'iat' => time(),
            'email' => $data['email'],
        ];

        $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');
        $this->LoginDao->saveToken($data['email'], $encode);
        return json_encode(array('token' => $encode));
    }

    public function verifyToken(string $token){
        return $this->LoginDao->updateToken($token);
    }
}