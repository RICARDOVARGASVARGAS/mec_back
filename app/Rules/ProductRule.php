<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductRule implements ValidationRule
{
    public $company_id, $product_id;

    public function __construct($company_id, $product_id)
    {
        $this->company_id = $company_id;
        $this->product_id = $product_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->product_id) {
            $product = Product::whereNot('id', $this->product_id)->where('company_id', $this->company_id)->where('name', $value)->first();
        } else {
            $product = Product::where('company_id', $this->company_id)->where('name', $value)->first();
        }

        if ($product) {
            $fail('El producto ya existe.');
        }
    }
}
