<?php

namespace App\Rules;

use App\Models\Color;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ColorRule implements ValidationRule
{
    public $company_id, $color_id;

    public function __construct($company_id, $color_id)
    {
        $this->company_id = $company_id;
        $this->color_id = $color_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->color_id) {
            $color = Color::whereNot('id', $this->color_id)->where('company_id', $this->company_id)->where('name', $value)->first();
        } else {
            $color = Color::where('company_id', $this->company_id)->where('name', $value)->first();
        }

        if ($color) {
            $fail('El Color ya existe.');
        }
    }
}
