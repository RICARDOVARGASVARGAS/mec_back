<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'search' => ['nullable', 'string'],
            'page' => ['nullable', 'integer', 'min:1'],
            'perPage' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', 'string', 'in:pending,done,cancelled,debt']
        ];
    }

    public function attributes(): array
    {
        return [
            'search' => 'Búsqueda',
            'page' => 'Página',
            'perPage' => 'Registros por página',
            'status' => 'Estado',
            'company_id' => 'Mecánica'
        ];
    }
}
