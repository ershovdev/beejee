<?php

namespace Core;

use App\Controllers\AuthController;
use App\Controllers\TaskController;
use App\Models\Auth;
use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;
use Src\Task;
use Src\User;

class Router
{
    private $router;

    private $routeData;

    private $response;

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->router = new RouteCollector();
        $this->entityManager = $entityManager;
    }

    public function process()
    {
        $this->collect();
        $this->dispatch();

        echo $this->response;
    }

    public function collect()
    {
        $authController = new AuthController($this->entityManager);
        $taskController = new TaskController($this->entityManager);

        $this->router->get('/signIn', function () use ($authController) {
            $authController->show();
        });

        $this->router->post('/signIn', function () use ($authController) {
            $authController->auth();
        });

        $this->router->get('/logout', function () use ($authController) {
            $authController->logout();
        });

        $this->router->get('/tasks', function () use ($taskController) {
            $taskController->show();
        });

        $this->router->get('/tasks/add', function () use ($taskController) {
            $taskController->create();
        });

        $this->router->post('/tasks/add', function () use ($taskController) {
            $taskController->store();
        });

        $this->router->post('/tasks/{id}/complete', function (int $id) use ($taskController) {
            $taskController->complete($id);
        });

        $this->router->get('/tasks/{id}/edit', function (int $id) use ($taskController) {
            $taskController->edit($id);
        });

        $this->router->post('/tasks/{id}/edit', function (int $id) use ($taskController) {
            $taskController->update($id);
        });

        $this->router->get('/users/add', function () {
            $user = new User();
            $auth = new Auth($this->entityManager);
            $user->setLogin('admin');
            $user->setPassword('123');
            $user->setEmail('123@123.ru');
            $user->setCreatedAt(new \DateTime());
            $user->setHash($auth->generateCode(10));

            try {
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                echo $e;
            }
            echo "Created User with ID " . $user->getId() . "\n";
        });

        $this->routeData = $this->router->getData();
    }

    public function dispatch()
    {
        $dispatcher = new Dispatcher($this->routeData);

        try {
            $this->response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $this->processInput($_SERVER['REQUEST_URI']));
        } catch (HttpRouteNotFoundException $e) {
            $this->response = '404!';
        } catch (HttpMethodNotAllowedException $e) {
            $this->response = 'This method is not allowed here!';
        }

        echo $this->response;
        die();
    }

    public function processInput($uri)
    {
        return urldecode(parse_url($uri, PHP_URL_PATH));
    }
}