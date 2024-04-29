<?php
namespace app\services;

use app\dao\LoginDAOMysql;
use PDO;
use app\models\UserModel;
use Dotenv\Dotenv as Dotenv;
use Firebase\JWT\JWT;

class LoginService{
    private $loginDao;
    private $user;

    public function __construct(PDO $db)
    {  
        $this->loginDao = new LoginDAOMysql($db);
        $this->user = new UserModel();
        $dotenv = Dotenv::createImmutable(__DIR__."../../.."); 
        $dotenv->load();
    }

    public function emailExists(string $email):bool
    {
        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $this->loginDao->findByEmail($this->user->email) ? true : false;
    }

    public function passwordEqual(string $email, string $password):bool
    {
        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $user = $this->loginDao->findByEmail($this->user->email);
        return password_verify($password, $user->password);
    }

    public function createToken(array $data):string
    {
        $payload = [
            'exp' => time() + 60000,
            'iat' => time(),
            'email' => $data['email'],
        ];

        $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');
        $this->loginDao->saveToken($data['email'], $encode);
        return json_encode(array('token' => $encode));
    }

    public function verifyToken(string $token):array|bool
    {
        return $this->loginDao->updateToken($token);
    }
}