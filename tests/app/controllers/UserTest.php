<?php
use app\config\Database;
use app\controllers\User as ControllersUser;
use app\services\UserService;
use PHPUnit\Framework\TestCase;
use app\models\UserModel;

class UserTest extends TestCase{

    private $controller;
    private $user;
    protected $conn;

    protected function setUp(): void
    {
        $this->user = new UserModel();
    }

    public function method(){
        $this->conn = Database::getConnection();
        return $this->controller = new ControllersUser($this->conn);
    }

    public function testStoreMethodCreatesNewUserSuccessfully()
    {
        $mockUserService = $this->getMockBuilder(UserService::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $mockUserService->expects($this->once())
                        ->method('emailExists')
                        ->willReturn(false);

        $mockUserService->expects($this->once())
                        ->method('newUser')
                        ->willReturn(['id' => 1, 'name' => 'John Doe', 'email' => 'john4@example.com']);

        $controller = $this->method();
        $controller->userService = $mockUserService;
        

        $expectedStatusCode = 201;
        $expectedResponse = json_encode(['id' => 1, 'name' => 'John Doe', 'email' => 'john4@example.com']);

        ob_start();
        $controller->store([['email' => 'john4@example.com', 'password' => 'password']]);
        $actualResponse = ob_get_clean();

        $this->assertEquals($expectedStatusCode, http_response_code());
        $this->assertEquals($expectedResponse, $actualResponse);
    }

    public function testStoreMethodReturnsErrorMessageWhenUserAlreadyExists()
    {
        $mockUserService = $this->getMockBuilder(UserService::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $mockUserService->expects($this->once())
                                ->method('emailExists')
                                ->with('john@example.com')
                                ->willReturn(true);
        
        // Criando uma instância do UserController e configurando o UserService mock
        $controller = $this->method();
        $controller->userService = $mockUserService;
        
        ob_start();
        $controller->store([['email' => 'john@example.com', 'password' => 'password']]);
        $actualResponse = ob_get_clean();
        $expectedResponse = json_encode(['message' => 'Usuario já existe']);
        $expectedStatusCode = 404;

        $this->assertEquals($expectedResponse, $actualResponse);
        $this->assertEquals($expectedStatusCode, http_response_code());
    }

    public function testStoreMethodReturnsErrorMessageWhenUserNotSendEmailOrPassword()
    {
        $mockUserService = $this->getMockBuilder(UserService::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $controller = $this->method();
        $controller->userService = $mockUserService;
        
        ob_start();
        $controller->store([['email' => 'john5@example.com']]);
        $actualResponse = ob_get_clean();
        
        $expectedResponse = json_encode(['message' => 'Email ou Password incorreto']);
        $expectedStatusCode = 404;
        
        $this->assertEquals($expectedResponse, $actualResponse);
        $this->assertEquals($expectedStatusCode, http_response_code());
    }
}