<?php 
namespace app\config;

use PDO;
use PDOException;
use Dotenv\Dotenv as Dotenv;

class Database
{ 
    public string $host;
    public string $db_name;
    public string $username;
    public string $password;
    public PDO $conn;

    public static function getConnection()
    {
        $dotenv = Dotenv::createImmutable(__DIR__."../../.."); 
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $db_name = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        try {
            $conn = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
            return null;
        }

        return $conn;
    }
}