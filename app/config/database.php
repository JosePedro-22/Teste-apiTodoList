<?php 
namespace app\config;

use PDO;
use PDOException;

class Database
{
    private static $host = 'localhost';
    private static $db_name = 'apiTodoList';
    private static $username = 'root';
    private static $password = '';
    private static $conn;

    public static function getConnection()
    {
        try {
            self::$conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name, self::$username, self::$password);
        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
        }

        return self::$conn;
    }
}