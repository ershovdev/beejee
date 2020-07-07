<?php

namespace App\Controllers;

use Core\Helpers;
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

        $errors = Helpers::getErrors();
        $success = Helpers::getSuccess();

        $sharedData = [
            'cookieId' => $this->cookieId,
            'cookieHash' => $this->cookieHash,
            'errors' => $errors,
            'success' => $success,
        ];

        $this->entityManager = $entityManager;
        $this->view = new View($sharedData);
    }
}