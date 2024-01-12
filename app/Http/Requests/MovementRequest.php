<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
            'detail' => ['required'],
            'date_movement' => ['required', 'date'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'box_id' => ['required', 'exists:boxes,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'monto',
            'detail' => 'detalle',
            'date_movement' => 'fecha',
            'client_id' => 'cliente',
            'box_id' => 'caja',
        ];
    }
}
