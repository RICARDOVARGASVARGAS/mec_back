<?php

namespace App\Http\Requests;

use App\Rules\ProductRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->routeIs('products.store')) {
            $name = new ProductRule(request()->company_id, null);
        } elseif (request()->routeIs('products.update')) {
            $name = new ProductRule(request()->company_id, $this->route('product')->id);
        }

        return [
            'name' => ['required', 'min:3', $name],
            'ticket' => ['required', 'min:3'],
            'price_buy' => ['required', 'numeric'],
            'price_sell' => ['required', 'numeric'],
            'image' => ['nullable', 'image'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'ticket' => 'nombre boleta',
            'price_buy' => 'precio de compra',
            'price_sell' => 'precio de venta',
            'image' => 'imagen',
            'company_id' => 'empresa',
        ];
    }
}
