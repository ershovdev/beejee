<?php

namespace App\Validators;

class TaskEditValidator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate()
    {
        $errors = [];
        if (!$this->data['text']) {
            $errors['text'] = 'Text is empty';
        }

        if (count($errors) === 0) return true;
        return $errors;
    }
}