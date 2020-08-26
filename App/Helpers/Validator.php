<?php


namespace App\Helpers;


class Validator
{
    public static function validate(array $fields, array $needFields): array
    {
        $emptyFields = [];

        foreach ($needFields as $key => $needField){

            if (empty($fields[$needField])) {
                $emptyFields[] = $needField;
                continue;
            }
        }
        return $emptyFields;
    }
}