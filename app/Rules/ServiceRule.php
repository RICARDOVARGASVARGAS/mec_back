<?php

namespace App\Rules;

use App\Models\Service;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ServiceRule implements ValidationRule
{
    public $company_id, $service_id;

    public function __construct($company_id, $service_id)
    {
        $this->company_id = $company_id;
        $this->service_id = $service_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->service_id) {
            $service = Service::whereNot('id', $this->service_id)->where('company_id', $this->company_id)->where('name', $value)->first();
        } else {
            $service = Service::where('company_id', $this->company_id)->where('name', $value)->first();
        }

        if ($service) {
            $fail('El Servicio ya existe.');
        }
    }
}
