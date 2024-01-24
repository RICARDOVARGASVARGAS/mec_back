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
        if (request()->routeIs('registerClient')) {
            $document = new ClientRule(request()->company_id, null);
        } elseif (request()->routeIs('updateClient')) {
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
            'document' => 'Documento',
            'name' => 'Nombre',
            'surname' => 'Apellido Paterno',
            'last_name' => 'Apellido Materno',
            'phone' => 'Teléfono',
            'email' => 'Correo Electrónico',
            'address' => 'Dirección',
            'image' => 'Imagen',
            'company_id' => 'Mecánica',
        ];
    }
}
