<?php


namespace App\Validators;


class TaskIndexParametersValidator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate()
    {
        $errors = [];
        if (!in_array($this->data['column'], ['id', 'username', 'email', 'status'])) {
            $errors['column'] = 'Wrong column';
        }

        if (!in_array($this->data['order'], ['ASC', 'DESC'])) {
            $errors['order'] = 'Wrong order';
        }

        try {
            intval($this->data['page']);
        } catch (\Exception $e) {
            $errors['page'] = 'Page is not a number!';
        }

        if (count($errors) === 0) return true;
        return $errors;
    }
}