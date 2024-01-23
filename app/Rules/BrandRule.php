<?php

namespace App\Rules;

use App\Models\Brand;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BrandRule implements ValidationRule
{
    public $company_id, $brand_id;

    public function __construct($company_id, $brand_id)
    {
        $this->company_id = $company_id;
        $this->brand_id = $brand_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->brand_id) {
            $brand = Brand::whereNot('id', $this->brand_id)->where('company_id', $this->company_id)->where('name', $value)->first();
        } else {
            $brand = Brand::where('company_id', $this->company_id)->where('name', $value)->first();
        }

        if ($brand) {
            $fail('La Marca ya existe.');
        }
    }
}
