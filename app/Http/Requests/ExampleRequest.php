<?php

namespace App\Http\Requests;

use App\Rules\ExampleRule;
use Illuminate\Foundation\Http\FormRequest;

class ExampleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('registerExample')) {
            $name = new ExampleRule(request()->company_id, null);
        } elseif (request()->routeIs('updateExample')) {
            $name = new ExampleRule(request()->company_id, $this->route('example')->id);
        }

        return [
            'name' => ['required', $name],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Modelo',
            'company_id' => 'Mecánica',
        ];
    }
}
