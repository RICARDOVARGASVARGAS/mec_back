<?php

namespace App\Http\Requests;

use App\Rules\BrandRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('brands.store')) {
            $name = new BrandRule(request()->company_id, null);
        } elseif (request()->routeIs('brands.update')) {
            $name = new BrandRule(request()->company_id, $this->route('brand')->id);
        }

        return [
            'name' => ['required', $name],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'company_id' => 'empresa',
        ];
    }
}
