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
        if (request()->routeIs('cars.store')) {
            $plate = new CarRule(request()->company_id, null);
        } elseif (request()->routeIs('cars.update')) {
            $plate = new CarRule(request()->company_id, $this->route('car')->id);
        }

        return [
            'plate' => ['required', $plate],
            'engine' => ['nullable'],
            'chassis' => ['nullable'],
            'image' => ['nullable', 'image'],
            'client_id' => ['required', 'exists:clients,id'],
            'example_id' => ['required', 'exists:examples,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'year_id' => ['required', 'exists:years,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'plate' => 'placa',
            'engine' => 'motor',
            'chassis' => 'chasis',
            'image' => 'imagen',
            'client_id' => 'cliente',
            'example_id' => 'modelo',
            'color_id' => 'color',
            'brand_id' => 'marca',
            'year_id' => 'año',
        ];
    }
}
