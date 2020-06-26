<?php

namespace Core;

class Helpers
{
    public static function setErrors(array $messages)
    {
        $_SESSION['errors'] = $messages;
    }

    public static function setSuccess(string $message)
    {
        $_SESSION['success'] = $message;
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