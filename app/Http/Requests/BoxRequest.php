<?php

namespace App\Http\Requests;

use App\Rules\BoxRule;
use Illuminate\Foundation\Http\FormRequest;

class BoxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        if (request()->routeIs('registerBox')) {
            $name = new BoxRule(request()->company_id, null);
        } elseif (request()->routeIs('updateBox')) {
            $name = new BoxRule(request()->company_id, $this->route('box')->id);
        }

        return [
            'name' => ['required', 'min:3', $name],
            'image' => ['nullable', 'image'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'image' => 'imagen',
            'company_id' => 'empresa',
        ];
    }
}
