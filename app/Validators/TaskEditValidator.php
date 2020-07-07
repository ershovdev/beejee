<?php

namespace App\Validators;

class TaskEditValidator
{
    public static function validate(string $text)
    {
        $errors = [];

        if (!$text) {
            $errors['text'] = 'Text is empty';
        }

        if (count($errors) === 0) return true;
        return $errors;
    }
}