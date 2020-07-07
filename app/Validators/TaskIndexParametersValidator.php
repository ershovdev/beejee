<?php


namespace App\Validators;


class TaskIndexParametersValidator
{
    public static function validate(string $column, string $order, string $page)
    {
        $errors = [];

        if (!in_array($column, ['id', 'username', 'email', 'status'])) {
            $errors['column'] = 'Wrong column';
        }

        if (!in_array($order, ['ASC', 'DESC'])) {
            $errors['order'] = 'Wrong order';
        }

        try {
            intval($page);
        } catch (\Exception $e) {
            $errors['page'] = 'Page is not a number!';
        }

        if (count($errors) === 0) return true;
        return $errors;
    }
}