<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    function getProducts(ListRequest $request)
    {
        $items = Product::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('ticket', 'like', '%' . $request->search . '%')
                    ->orWhere('price_buy', 'like', '%' . $request->search . '%')
                    ->orWhere('price_sell', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc')->paginate($request->perPage, ['*'], 'page', $request->page);

        return ProductResource::collection($items);
    }

    function registerProduct(ProductRequest $request)
    {
        $item = Product::create([
            'number' => Product::where('company_id', $request->company_id)->max('number') + 1,
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

    function getProduct($product)
    {
        $product = Product::included()->find($product);
        return ProductResource::make($product);
    }

    function updateProduct(ProductRequest $request, Product $product)
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

    function deleteProduct(Product $product)
    {
        try {
            $image = $product->image;
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            if ($image) {
                Storage::delete($image);
            }
            return ProductResource::make($product);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
