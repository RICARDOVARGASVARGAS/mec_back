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
            'payment_date' => ['nullable', 'date'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'in:pending,done,cancelled,debt'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'car_id' => ['required', 'exists:cars,id'],
            'observation' => ['nullable'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'km' => 'Kilometraje',
            'entry_date' => 'Fecha de Entrada',
            'exit_date' => 'Fecha de Salida',
            'discount' => 'Descuento',
            'status' => 'Estado',
            'client_id' => 'Cliente',
            'car_id' => 'Vehículo',
            'company_id' => 'Mecánica',
        ];
    }
}
