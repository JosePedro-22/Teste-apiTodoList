<?php

use app\config\Database;
use app\controllers\Task as ControllersTask;
use app\services\TaskService;
use PHPUnit\Framework\TestCase;
use app\models\TaskModel;
use app\models\UserModel;

class TaskTest extends TestCase
{
    private $controller;
    private $task;
    private $user;
    private $data;
    protected $conn;

    protected function setUp(): void
    {
        $this->task = new TaskModel();
        $this->user = new UserModel();
        $this->method();
    }

    public function method(){
        $this->conn = Database::getConnection();
        $this->controller = new ControllersTask();
        $this->controller->data = new TaskService($this->conn);
        return $this->controller;
    }

    // public function testIndexMethodReturnsNoTasksMessageWhenUserHasNoTasks()
    // {
    //     $this->user->id = 2;

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();

    //     $mockTaskService->expects($this->once())
    //                     ->method('getAllTasks');
    //                     // ->will(['error' => 'Erro ao buscar tarefas']);

    //     $mockTaskService->getAllTasks($this->user->id);

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
                        
    //     ob_start();
    //     $controller->index([], $this->user);
    //     $actualResponse = ob_get_clean();

    //     $expectedResponse = json_encode(["message" => "O Usuario não possui nenhuma Task"]);
    //     $expectedStatusCode = 404;

    //     $this->assertEquals($expectedResponse, $actualResponse);
    //     $this->assertEquals($expectedStatusCode, http_response_code());
    // }
    
    // // User tem uma tarefa (Vareificar se tiver mais de uma tarefa no banco deletar)
    // public function testIndexMethodReturnsTasksWhenUserHasTasks()
    // {
    //     $this->user->id = 1;

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                         ->disableOriginalConstructor()
    //                         ->getMock();

    //     $mockTaskService->expects($this->once())
    //             ->method('getAllTasks')
    //             ->with($this->equalTo($this->user->id))
    //             ->willReturn([
    //                 "id" => 11,
    //                 "title" => "task One 1",
    //                 "description" => "testando",
    //                 "status" => 1,
    //                 "user_id" => 1,
    //                 "created_at" => "2024-04-27 23:51:11",
    //                 "updated_at" => "2024-04-28 00:08:49"
    //             ]);

    //     $mockTaskService->getAllTasks($this->user->id);

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
                        
    //     ob_start();
    //     $controller->index([], $this->user);
    //     $actualResponse = ob_get_clean();

    //     $expectedResponse = json_encode([
    //         ["id" => 11,
    //         "title"=>"task One 1",
    //         "description"=> "testando",
    //         "status"=> 1,
    //         "user_id"=> 1,
    //         "created_at"=> "2024-04-27 23:51:11",
    //         "updated_at"=> "2024-04-28 00:08:49"]
    //     ]);

    //     $expectedStatusCode = 200;

    //     $this->assertEquals($expectedResponse, $actualResponse);
    //     $this->assertEquals($expectedStatusCode, http_response_code());
    // }

    // public function testFindMethodReturnsTaskOnSuccessFindById()
    // {
    //     $params = [11];
    //     $this->user->id = 1;

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();

    //     $mockTaskService->expects($this->once())
    //                     ->method('getByIdTask')
    //                     ->with($params[0])
    //                     ->willReturn([
    //                         "id" => 11,
    //                         "title" => "task One 1",
    //                         "description" => "testando",
    //                         "status" => 1,
    //                         "user_id" => 1,
    //                         "created_at" => "2024-04-27 23:51:11",
    //                         "updated_at" => "2024-04-28 00:08:49"
    //                     ]);

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
    //     $mockTaskService->getByIdTask($params[0]);

    //     // Capturando a saída do método find()
    //     ob_start();
    //     $controller->find($params, $this->user);
    //     $actualResponse = ob_get_clean();
        
    //     // Verificando se a resposta contém a tarefa esperada
    //     $expectedResponse = json_encode([
    //         "id" => 11,
    //         "title" => "task One 1",
    //         "description" => "testando",
    //         "status" => 1,
    //         "user_id" => 1,
    //         "created_at" => "2024-04-27 23:51:11",
    //         "updated_at" => "2024-04-28 00:08:49"
    //     ]);

    //     $this->assertEquals($expectedResponse, $actualResponse);
    // }

    // public function testFindMethodReturnsNoTaskWhenTaskNotFound()
    // {
    //     $params = [12];
    //     $this->user->id = 1;

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();

    //     $mockTaskService->expects($this->once())
    //                     ->method('getByIdTask')
    //                     ->with($params[0])
    //                     ->willReturn([]);


    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
    //     $mockTaskService->getByIdTask($params[0]);

    //     ob_start();
    //     $controller->find($params, $this->user);
    //     $actualResponse = ob_get_clean();
        
    //     $expectedResponse = json_encode(["message" => "Não existe nenhuma Task"]);

    //     $expectedStatusCode = 404;
    //     $this->assertEquals($expectedResponse, $actualResponse);
    //     $this->assertEquals($expectedStatusCode, http_response_code());
    // }
    
    // public function testStoreMethodReturnsInvalidTitleOrDescriptionError()
    // {
    //     $body = [
    //         ['title' => 'T1', 'description' => 'D1']
    //     ];
    //     $this->user->id = 1;

    //     $controller = $this->method();

    //     ob_start();
    //     $controller->store($body, $this->user);
    //     $actualResponse = ob_get_clean();

    //     $expectedResponse = json_encode(["message" => "Titulo ou Descricao invalidos"]);
    //     $expectedStatusCode = 404;

    //     $this->assertEquals($expectedResponse, $actualResponse);
    //     $this->assertEquals($expectedStatusCode, http_response_code());
    // }

    // public function testStoreMethodCreatesTaskSuccessfully()
    // {
    //     $body = [
    //         ['title' => 'Task 1', 'description' => 'Task description 1']
    //     ];
    //     $user = [
    //         'id' => 1
    //     ];

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();

    //     $mockTaskService->expects($this->once())
    //                     ->method('newTask')
    //                     ->with($body[0], $user['id'])
    //                     ->willReturn([
    //                         "title" => "Task 1",
    //                         "description" => "Task description 1",
    //                         "status" => 1,
    //                     ]);

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
    //     $mockTaskService->newTask($body[0], $user['id']);

    //     ob_start();
    //     $controller->store($body, $user);
    //     $actualResponse = ob_end_clean();
        
    //     $expectedResponse = json_encode([
    //         "title" => "Task 1",
    //         "description" => "Task description 1",
    //         "status" => 0,
    //         "user_id" => $user['id'],
    //     ]);
    
    //     $this->assertEquals($expectedResponse,$actualResponse);
    // }

    // public function testUpdateMethodReturnsInvalidTitleOrDescriptionError()
    // {
    //     $body = [
    //         ['title' => 'T1', 'description' => 'D1']
    //     ];
    //     $user = [
    //         'id' => 11
    //     ];
    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();

    //     $mockTaskService->expects($this->once())
    //                     ->method('updateTask')
    //                     ->with($user['id'],$body[0]);
    

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
    //     $mockTaskService->updateTask($user['id'],$body[0]);

    //     ob_start();
    //     $controller->update($body, $user);
    //     $actualResponse = ob_end_clean();


    //     $expectedResponse = json_encode(["message" => "Titulo ou Descricao invalidos"]);
    //     $expectedStatusCode = 404;

    //     $this->assertEquals($expectedResponse, $actualResponse);
    //     $this->assertEquals($expectedStatusCode, http_response_code());
    // }

    // public function testUpdateMethodUpdateTaskSuccessfully()
    // {
    //     $body = [
    //         ['title' => 'Task 1', 'description' => 'Task description 1']
    //     ];
    //     $user = [
    //         'id' => 11
    //     ];

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();
    //     $mockTask = new TaskModel();
        
    //     $mockTaskService->expects($this->once())
    //                     ->method('updateTask')
    //                     ->with($user['id'],$body[0])
    //                     ->willReturn($mockTask);

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
    //     $mockTaskService->updateTask($user['id'],$body[0]);

    //     ob_start();
    //     $controller->update($body, $user);
    //     $actualResponse = ob_end_clean();
        
    //     $this->assertJson($actualResponse);

    //     $expectedResponse = new TaskModel();
    //     $expectedStatusCode = 200;

    //     $this->assertEquals($expectedResponse, $actualResponse);
    //     $this->assertEquals($expectedStatusCode, http_response_code());

    //     $this->assertEquals($mockTask, $expectedResponse);
    // }
    
    // // verificar se o id da tarefa existe 
    // public function testDeleteMethodDeletesTaskSuccessfully()
    // {
    //     $body =  [59];
    //     $user = [1];

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();

    //     $mockTaskService->expects($this->once())
    //                     ->method('deleteTask')
    //                     ->with($body[0])
    //                     ->willReturn(true);

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
    //     $mockTaskService->deleteTask($body[0]);

    //     ob_start();
    //     $controller->delete($body, $user);
    //     $actualResponse = ob_get_clean();

    //     $this->assertJson($actualResponse);
    //     $expectedStatusCode = 200;

    //     $expectedResponse = json_encode(["message" => "Task excluída com sucesso"]);
    //     $this->assertEquals($expectedStatusCode, http_response_code());
    //     $this->assertEquals($expectedResponse, $actualResponse);
    // }

    //     // verificar se o id da tarefa existe 
    // public function testDeleteMethodDeletesTaskNotSuccessfully()
    // {
    //     $body =  [59];
    //     $user = [1];

    //     $mockTaskService = $this->getMockBuilder(TaskService::class)
    //                             ->disableOriginalConstructor()
    //                             ->getMock();

    //     $mockTaskService->expects($this->once())
    //                     ->method('deleteTask')
    //                     ->with($body[0]);

    //     $controller = $this->method();
    //     $controller->data = $mockTaskService;
    //     $mockTaskService->deleteTask($body[0]);

    //     ob_start();
    //     $controller->delete($body, $user);
    //     $actualResponse = ob_get_clean();

    //     $expectedResponse = json_encode(["message" => "Task não encontrado"]);
    //     $this->assertEquals($expectedResponse, $actualResponse);
    // }
}
