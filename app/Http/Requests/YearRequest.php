<?php

namespace App\Http\Requests;

use App\Rules\YearRule;
use Illuminate\Foundation\Http\FormRequest;

class YearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('registerYear')) {
            $name = new YearRule(request()->company_id, null);
        } elseif (request()->routeIs('updateYear')) {
            $name = new YearRule(request()->company_id, $this->route('year')->id);
        }

        return [
            'name' => ['required', $name],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Año',
            'company_id' => 'Mecánica',
        ];
    }
}
