<?php

namespace App\Rules;

use App\Models\Car;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CarRule implements ValidationRule
{
    public $company_id, $car_id;

    public function __construct($company_id, $car_id)
    {
        $this->company_id = $company_id;
        $this->car_id = $car_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->car_id) {
            $car = Car::whereNot('id', $this->car_id)
                ->whereRelation('client', 'company_id', $this->company_id)
                ->where('plate', $value)->first();
        } else {
            $car = Car::whereRelation('client', 'company_id', $this->company_id)->where('plate', $value)->first();
            // dd($this->company_id, $value, $car);
        }

        if ($car) {
            $fail('La Placa ya existe.');
        }
    }
}
