<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'detail' => ['nullable'],
            'amount' => ['required', 'numeric', 'min:0'],
            'date_payment' => ['required', 'date'],
            'sale_id' => ['required', 'exists:sales,id'],
            'box_id' => ['required', 'exists:boxes,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'detail' => 'detalle',
            'amount' => 'monto',
            'date_payment' => 'fecha',
            'sale_id' => 'venta',
            'box_id' => 'caja',
        ];
    }
}
