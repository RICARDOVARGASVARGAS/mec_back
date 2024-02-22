<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'property_calculate' => ['nullable', 'string'],
            'driver_calculate' => ['nullable', 'string'],
            'ruc_calculate' => ['nullable', 'string'],
            'dni_calculate' => ['nullable', 'string'],
            'phone_calculate' => ['nullable', 'string'],
            'cel_property_calculate' => ['nullable', 'string'],
            'cel_driver_calculate' => ['nullable', 'string'],
            'address_calculate' => ['nullable', 'string'],
            'plate_calculate' => ['nullable', 'string'],
            'engine_calculate' => ['nullable', 'string'],
            'chassis_calculate' => ['nullable', 'string'],
            'brand_calculate' => ['nullable', 'string'],
            'model_calculate' => ['nullable', 'string'],
            'year_car_calculate' => ['nullable', 'string'],
            'color_calculate' => ['nullable', 'string'],
            'km_calculate' => ['nullable', 'string'],
            'observation_calculate' => ['nullable', 'string'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'property_calculate' => 'Propietario',
            'driver_calculate' => 'Conductor',
            'ruc_calculate' => 'RUC',
            'dni_calculate' => 'DNI',
            'phone_calculate' => 'Teléfono',
            'cel_property_calculate' => 'Celular Propietario',
            'cel_driver_calculate' => 'Celular Conductor',
            'address_calculate' => 'Dirección',
            'plate_calculate' => 'Placa',
            'engine_calculate' => 'Motor',
            'chassis_calculate' => 'Chasis',
            'brand_calculate' => 'Marca',
            'model_calculate' => 'Modelo',
            'year_car_calculate' => 'Año',
            'color_calculate' => 'Color',
            'km_calculate' => 'Kilómetros',
            'observation_calculate' => 'Observación',
            'company_id' => 'Mecánica',
        ];
    }
}
