<?php

namespace Core;

use Doctrine\ORM\EntityManager;

class App
{
    private $router;

    public function make(EntityManager $entityManager)
    {
        $this->router = new Router($entityManager);
    }

    public function process()
    {
        $this->router->process();
    }
}