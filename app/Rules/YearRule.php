<?php

namespace App\Rules;

use App\Models\Year;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YearRule implements ValidationRule
{
    public $company_id, $year_id;

    public function __construct($company_id, $year_id)
    {
        $this->company_id = $company_id;
        $this->year_id = $year_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->year_id) {
            $year = Year::whereNot('id', $this->year_id)->where('company_id', $this->company_id)->where('name', $value)->first();
        } else {
            $year = Year::where('company_id', $this->company_id)->where('name', $value)->first();
        }

        if ($year) {
            $fail('La año ya está registrado.');
        }
    }
}
