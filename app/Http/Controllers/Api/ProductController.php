<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    function index(Request $request)
    {
        $items = Product::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('ticket', 'like', '%' . $request->search . '%')
                    ->orWhere('price_buy', 'like', '%' . $request->search . '%')
                    ->orWhere('price_sell', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return ProductResource::collection($items);
    }

    function store(ProductRequest $request)
    {
        $item = Product::create([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'company_id' => $request->company_id
        ]);

        return ProductResource::make($item)->additional([
            'message' => 'Producto Registrado.'
        ]);
    }

    function show(Product $product)
    {
        return ProductResource::make($product);
    }

    function update(ProductRequest $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'company_id' => $request->company_id
        ]);

        return ProductResource::make($product)->additional([
            'message' => 'Producto Actualizado.'
        ]);
    }

    function destroy(Product $product)
    {
        $product->delete();
        if ($product->image) {
            Storage::delete($product->image);
        }
        return ProductResource::make($product)->additional([
            'message' => 'Producto Eliminado.'
        ]);
    }
}
