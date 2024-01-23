<?php

namespace App\Rules;

use App\Models\Example;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExampleRule implements ValidationRule
{
    public $company_id, $example_id;

    public function __construct($company_id, $example_id)
    {
        $this->company_id = $company_id;
        $this->example_id = $example_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->example_id) {
            $example = Example::whereNot('id', $this->example_id)->where('company_id', $this->company_id)->where('name', $value)->first();
        } else {
            $example = Example::where('company_id', $this->company_id)->where('name', $value)->first();
        }

        if ($example) {
            $fail('La caja ya existe.');
        }
    }
}
