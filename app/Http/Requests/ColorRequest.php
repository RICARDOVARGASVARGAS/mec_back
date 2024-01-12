<?php

namespace App\Http\Requests;

use App\Rules\ColorRule;
use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('colors.store')) {
            $name = new ColorRule(request()->company_id, null);
        } elseif (request()->routeIs('colors.update')) {
            $name = new ColorRule(request()->company_id, $this->route('color')->id);
        }

        return [
            'name' => ['required', $name],
            'hex' => ['required'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'hex' => 'color',
            'company_id' => 'empresa',
        ];
    }
}
