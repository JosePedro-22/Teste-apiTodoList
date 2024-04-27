<?php
namespace app\services;

use app\dao\UserDaoMysql;
use PDO;
use app\models\User as ModelsUser;
// use Dotenv\Dotenv;
use Firebase\JWT\JWT;

// require_once "../../vendor/autoload.php";

class LoginService{
    public $driver;
    public $userDao;
    public $user;
    public function __construct(PDO $db)
    {  
        $this->driver = $db;
        $this->userDao = new UserDaoMysql($this->driver);
        $this->user = new ModelsUser();
    }

    public function EmailExists(string $email){
        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $this->userDao->findByEmail($this->user->email) ? true :  false;
    }

    public function PasswordEqual(string $email, string $password){

        $this->user->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $user = $this->userDao->findByEmail($this->user->email);
        return password_verify($password, $user->password);
    }

    public function CreateToken(array $data){
        
        // $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
        // $dotenv->load();

        // $KEY='';

        $expire_in = time() + 60000;

        $payload = [
            'exp' => $expire_in,
            'iat' => time(),
            'email' => $data['email'],
        ];

        $encode = JWT::encode($payload, $GLOBALS['secretJWT'], 'HS256');
        $this->userDao->saveToken($data['email'], $encode);
        return json_encode(array('token' => $encode));
    }

    public function VerifyToken(string $token){
        return $this->userDao->updateToken($token);
    }
}