<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('companies.store')) {
            $name = 'unique:companies,name';
        } elseif (request()->routeIs('companies.update')) {
            $name = 'unique:companies,name,' . request()->route('company')->id;
        }

        return [
            'name' => ['required', $name],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'image' => ['nullable', 'image'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
            'image' => 'imagen',
        ];
    }
}
