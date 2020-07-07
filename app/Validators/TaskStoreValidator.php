<?php

namespace App\Validators;

class TaskStoreValidator
{
    public static function validate(string $username, string $email, string $text)
    {
        $errors = [];

        if (!$username) {
            $errors['username'] = 'Empty username';
        }

        if (!$email) {
            $errors['email'] = 'Empty email';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email is incorrect';
            }
        }

        if (!$text) {
            $errors['text'] = 'Empty text';
        }

        if (count($errors) === 0) return true;
        return $errors;
    }

}