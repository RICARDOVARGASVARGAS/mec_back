<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('registerUser')) {
            $email = 'unique:users,email';
        } elseif (request()->routeIs('updateUser')) {
            $email = 'unique:users,email,' . request()->route('user')->id;
        }

        return [
            'names' => ['required', 'string'],
            'surnames' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email', $email],
            'status' => ['required', 'in:active,inactive'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'names' => 'Nombres',
            'surnames' => 'Apellidos',
            'phone' => 'Teléfono',
            'email' => 'Correo Electrónico',
            'company_id' => 'Mecánica',
            'status' => 'Estado',
        ];
    }
}
