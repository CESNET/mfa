<?php

namespace App\Services;

use Throwable;

class ErrorService
{
    public function getErrors()
    {
        try {
            $errors = [];

            foreach (explode('&', $_SERVER['QUERY_STRING']) as $string) {
                $error = explode('=', $string);
                $errors[$error[0]] = $error[1];
            }

            return $errors;
        } catch (Throwable $t) {
            return [];
        }
    }
}
