<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'km' => ['nullable'],
            'entry_date' => ['nullable', 'date'],
            'exit_date' => ['nullable', 'date'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'in:pending,done,cancelled,debt'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'car_id' => ['required', 'exists:cars,id'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'km' => 'kilometraje',
            'entry_date' => 'fecha de entrada',
            'exit_date' => 'fecha de salida',
            'discount' => 'descuento',
            'status' => 'estado',
            'client_id' => 'cliente',
            'car_id' => 'vehículo',
            'company_id' => 'empresa',
        ];
    }
}
