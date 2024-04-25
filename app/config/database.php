<?php 

// $base = 'http://localhost:8000';

// $db_name = 'apiTodoList';
// $db_host = 'localhost';
// $db_user = 'root';
// $db_password = '';

// $pdo = new PDO('mysql:dbname='.$db_name.';host='.$db_host, $db_user, $db_password);

class Database
{
    private $host = 'localhost';
    private $db_name = 'apiTodoList';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
        }

        return $this->conn;
    }
}