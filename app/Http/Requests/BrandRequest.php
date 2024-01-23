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
        if (request()->routeIs('registerBrand')) {
            $name = new BrandRule(request()->company_id, null);
        } elseif (request()->routeIs('updateBrand')) {
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
            'name' => 'Marca',
            'company_id' => 'Mecánica',
        ];
    }
}
