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
            'client_id' => ['nullable', 'exists:clients,id'],
            'car_id' => ['nullable', 'exists:cars,id'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'client_id' => 'Cliente',
            'car_id' => 'Vehículo',
            'company_id' => 'Mecánica',
        ];
    }
}
