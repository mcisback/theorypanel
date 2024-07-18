<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImageDataUri implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match('/^data:image\/(png|jpg|jpeg|gif);base64,[A-Za-z0-9+\/=]+$/i', $value)) {
            $fail(':attribute invalid: only png|jpg|jpeg|gif are allowed');
        }
    }
}
