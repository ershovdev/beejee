<?php

namespace Core;

class View
{
    public static function show(string $view, array $data = [])
    {
        if (isset($data) && $data) extract($data);

        require_once '../resources/views/layout/header.php';
        require_once '../resources/views/' . $view . '.php';
        require_once '../resources/views/layout/footer.php';
    }
}