<?php

namespace App\Rules;

use App\Models\Book;
use Illuminate\Contracts\Validation\Rule;

class ISBN implements Rule
{   
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $isbn = str_replace(' ', '', $value); // remove any space
        $isbn = str_replace('-', '', $isbn); // remove hyphens 
        //dd(preg_match('/\d{13}/i', $isbn));

        // ISBN must be 13 digits number
        if (strlen($isbn) != 13) {
            return false;
        }

        if (preg_match('/\d{13}/i', $isbn) == false) {
            return false;
        }

        if ($this->checksum($isbn)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Calculation of isbn
     * 
     * (x1 + 3x2 + x3 + 3x4 + x5 + 3x6 + x7 + 3x8 + x9 + 3x10 + x11 + 3x12 + x13) % 10 = 0
     */
    private function checksum($isbn)
    {
        $check = 0;

        // sum alternate digits starting from 1st to 13th digit
        for ($i = 0; $i < 13; $i += 2) {
            $check += (int)$isbn[$i];
        }

        // sum alternate digits multiplied by 3, starting from 2nd to 12th digit
        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * $isbn[$i];
        }

        return $check % 10 === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid ISBN';
    }
}
