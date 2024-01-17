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
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'names' => 'nombres',
            'surnames' => 'apellidos',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'company_id' => 'empresa',
        ];
    }
}
