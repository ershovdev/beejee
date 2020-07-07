<?php

namespace Core;

class View
{
    private $sharedData;

    public function __construct(array $data = [])
    {
        $this->sharedData = $data;
    }

    public function show(string $view, array $data = [])
    {
        $data = array_merge($data, $this->sharedData);
        if (isset($data) && $data) extract($data);

        require_once '../resources/views/layout/header.php';
        require_once '../resources/views/' . $view . '.php';
        require_once '../resources/views/layout/footer.php';

        \Core\Helpers::setSuccess(null);
        \Core\Helpers::setErrors(null);
    }
}