<?php

namespace App\Controllers;

use Core\Helpers;
use Core\View;
use App\Models\Auth;
use Doctrine\ORM\EntityManager;

class AuthController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function show()
    {
        View::show('auth');
    }

    public function auth()
    {
        if (!isset($_POST['submit'])) {
            Helpers::setErrors(['Something went wrong']);
            Helpers::redirect('/signIn');
            return;
        }

        $auth = new Auth($this->entityManager);
        $result = $auth->login($_POST['login'], $_POST['password']);

        if ($result) {
            Helpers::setSuccess('You are now logged in!');
            Helpers::redirect('/tasks');
        } else {
            Helpers::setErrors(['Incorrect login or password']);
            Helpers::redirect('/signIn');
        }
    }

    public function logout()
    {
        $auth = new Auth($this->entityManager);
        $auth->logout();
    }
}