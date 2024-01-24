<?php

namespace App\Http\Requests;

use App\Rules\CarRule;
use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('registerCar')) {
            $plate = new CarRule(request()->company_id, null);
        } elseif (request()->routeIs('updateCar')) {
            $plate = new CarRule(request()->company_id, $this->route('car')->id);
        }

        return [
            'plate' => ['required', $plate],
            'engine' => ['nullable'],
            'chassis' => ['nullable'],
            'client_id' => ['required', 'exists:clients,id'],
            'example_id' => ['required', 'exists:examples,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'year_id' => ['required', 'exists:years,id'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'plate' => 'Placa',
            'engine' => 'Motor',
            'chassis' => 'MChasis',
            'client_id' => 'Cliente',
            'example_id' => 'Modelo',
            'color_id' => 'Color',
            'brand_id' => 'Marca',
            'year_id' => 'Año',
            'company_id' => 'Mecánica',
        ];
    }
}
