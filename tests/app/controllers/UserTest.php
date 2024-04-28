<?php
require "./app/models/User.php";

use app\config\Database;
use app\services\UserService;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase{

    private $userService;
    protected $conn;

    protected function setUp(): void
    {
        parent::setUp();
        $this->conn = Database::getConnection();
    }

    public function testCanBeCreatedNewUser(): void
    {
        // Dados para o novo usuário
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret'
        ];

        // Executar o método newUser
        // $result = $this->userService->newUser($data);
        $userService = new UserService($this->conn);
        $result = $userService->newUser($data);

        // Verificar se o resultado é verdadeiro (inserção bem-sucedida)
        $this->assertTrue($result);
        $this->assertEquals(200, http_response_code());
    }
}