<?php

namespace Core;

use App\Controllers\AuthController;
use App\Controllers\TaskController;
use Doctrine\ORM\EntityManager;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;

class Router
{
    private $router;
    private $routeData;
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

        $this->routeData = $this->router->getData();
    }

    public function dispatch()
    {
        $dispatcher = new Dispatcher($this->routeData);

        try {
            $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $this->processInput($_SERVER['REQUEST_URI']));
        } catch (HttpRouteNotFoundException $e) {
            View::show('404');
            die();
        } catch (HttpMethodNotAllowedException $e) {
            View::show('badmethod');
            die();
        }

        echo $response;
        die();
    }

    public function processInput($uri)
    {
        return urldecode(parse_url($uri, PHP_URL_PATH));
    }
}