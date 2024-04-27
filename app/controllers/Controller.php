<?php
namespace app\controllers;

use app\config\Database as DatabaseConfig;
use PDO;

class Controller {
    protected static $db;

    public function __construct() {
        if (!self::$db) {
            self::$db = DatabaseConfig::getConnection();
        }
    }

    protected function getRequestBody()
    {
        $json = file_get_contents("php://input");
        $obj = json_decode($json);

        return $obj;
    }
}