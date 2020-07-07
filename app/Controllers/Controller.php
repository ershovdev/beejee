<?php

namespace App\Controllers;

use Core\View;
use Doctrine\ORM\EntityManager;

class Controller
{
    protected $entityManager;
    protected $view;
    protected $cookieId;
    protected $cookieHash;

    public function __construct(EntityManager $entityManager)
    {
        $this->cookieId = $_COOKIE['id'] ?? null;
        $this->cookieHash = $_COOKIE['hash'] ?? null;

        $sharedData = [
            'cookieId' => $this->cookieId,
            'cookieHash' => $this->cookieHash,
        ];

        $this->entityManager = $entityManager;
        $this->view = new View($sharedData);
    }
}