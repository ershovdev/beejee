<?php

namespace App\Models;

use Core\Helpers;
use Doctrine\ORM\EntityManager;
use App\Db\User;

class Auth
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    function generateCode($length = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    public function checkLoginAndPassword(string $login, string $password)
    {
        return $login === 'admin' && $password === '123';
    }

    public function login(string $login, string $password)
    {
        if ($this->checkLoginAndPassword($login, $password)) {
            $hash = md5($this->generateCode(10));

            $user = $this->entityManager->find('\App\Db\User', 1);
            $user->setHash($hash);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            setcookie("id", $user->getId(), time()+60*60*24*30, '/');
            setcookie("hash", $hash, time()+60*60*24*30, '/', null, null, true);

            return true;
        } else {
            return false;
        }
    }

    public static function isLoggedIn(?int $id, ?string $hash)
    {
        if (isset($id) && isset($hash)) return true;
        return false;
    }
}