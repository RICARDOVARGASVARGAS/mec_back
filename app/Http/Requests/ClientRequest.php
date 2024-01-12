<?php

namespace App\Http\Requests;

use App\Rules\ClientRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('clients.store')) {
            $document = new ClientRule(request()->company_id, null);
        } elseif (request()->routeIs('clients.update')) {
            $document = new ClientRule(request()->company_id, $this->route('client')->id);
        }

        return [
            'document' => ['required', $document],
            'name' => ['required', 'string'],
            'surname' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'image' => ['nullable', 'image'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'document' => 'documento',
            'name' => 'nombre',
            'surname' => 'apellido paterno',
            'last_name' => 'apellido materno',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'address' => 'dirección',
            'image' => 'imagen',
            'company_id' => 'empresa',
        ];
    }
}
