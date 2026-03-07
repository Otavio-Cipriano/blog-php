<?php

namespace Core;

use Exception;

class Validate
{
    private array $options = ['string', 'email', 'int', 'float', 'max', 'min'];
    public function __construct()
    {
    }

    public function validate(mixed $value, string $filter)
    {

    }

    private function getFilters(string $filter)
    {
        $filters = explode('|', $filter);
    }

    private function validateString(?string $field, mixed $value)
    {
        try {
            if(!is_string($value)){
                throw new Exception("$field is not a string");
            }

            return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);

        }catch (Exception $e){
            echo "Caught exception: " . $e->getMessage();
            die();
        }
    }

    private function validateEmail(?string $field, mixed $value)
    {
        try {
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                throw new Exception("$field is not a string");
            }

            return filter_var($value, FILTER_SANITIZE_EMAIL);

        }catch (Exception $e){
            echo "Caught exception: " . $e->getMessage();
            die();
        }
    }
}