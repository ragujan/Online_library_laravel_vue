<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class AllowedNameTitles implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        //validation will if the value has any other than the characters included in the 
        // regex matching
        // Invalid character checking
        if (!preg_match("/^[a-zA-Z0-9\(\)\ \–\-\,\.\[\]\|\_]+$/", $value)) {
            $fail('The :The value contains invalid characters');
        }
    }
}