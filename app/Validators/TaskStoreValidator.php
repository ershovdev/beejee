<?php

namespace App\Validators;

class TaskStoreValidator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate()
    {
        $errors = [];

        if (!$this->data['username']) {
            $errors['username'] = 'Empty username';
        }

        if (!$this->data['email']) {
            $errors['email'] = 'Empty email';
        } else {
            if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email is incorrect';
            }
        }

        if (!$this->data['text']) {
            $errors['text'] = 'Empty text';
        }

        if (count($errors) === 0) return true;
        return $errors;
    }

}