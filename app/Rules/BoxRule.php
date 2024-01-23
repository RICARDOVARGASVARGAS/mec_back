<?php

namespace App\Rules;

use App\Models\Box;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BoxRule implements ValidationRule
{
    public $company_id, $box_id;

    public function __construct($company_id, $box_id)
    {
        $this->company_id = $company_id;
        $this->box_id = $box_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->box_id) {
            $box = Box::whereNot('id', $this->box_id)->where('company_id', $this->company_id)->where('name', $value)->first();
        } else {
            $box = Box::where('company_id', $this->company_id)->where('name', $value)->first();
        }

        if ($box) {
            $fail('La caja ya existe.');
        }
    }
}
