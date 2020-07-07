<?php

namespace Core;

class Helpers
{
    public static function setErrors(?array $messages)
    {
        $_SESSION['errors'] = $messages;
    }

    public static function setSuccess(?string $message)
    {
        $_SESSION['success'] = $message;
    }

    public static function getErrors()
    {
        return isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
    }

    public static function getSuccess()
    {
        return isset($_SESSION['success']) ? $_SESSION['success'] : null;
    }

    public static function redirect(string $route)
    {
        header("Location: {$route}");
    }

    public static function escape(string $string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}