<?php

namespace App\Http\Requests;

use App\Rules\ServiceRule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('services.store')) {
            $name = new ServiceRule(request()->company_id, null);
        } elseif (request()->routeIs('services.update')) {
            $name = new ServiceRule(request()->company_id, $this->route('service')->id);
        }

        return [
            'name' => ['required', 'min:3', $name],
            'ticket' => ['required', 'min:3'],
            'image' => ['nullable', 'image'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'ticket' => 'nombre boleta',
            'image' => 'imagen',
            'company_id' => 'empresa',
        ];
    }
}
