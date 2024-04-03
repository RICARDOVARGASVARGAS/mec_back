<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calculate;
use App\Models\ProductCalculate;
use Illuminate\Http\Request;

class ProductCalculateController extends Controller
{
    function getListProductsCalculate(Calculate $calculate)
    {
        $items = $calculate->productCalculates;
        $total = floatval($calculate->productCalculates->sum(function ($product) {
            return $product->amount * $product->price;
        }));
        return response()->json([
            'calculate' => $calculate,
            'items' => $items,
            'total' => $total
        ]);
    }

    function registerProductCalculate(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'brand' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'calculate_id' => ['required', 'exists:calculates,id']
        ], [], [
            'calculate_id' => 'Cotización',
            'amount' => 'Cantidad',
            'description' => 'Descripción',
            'brand' => 'Marca',
            'price' => 'Precio'
        ]);

        $item = ProductCalculate::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'brand' => $request->brand,
            'price' => $request->price,
            'calculate_id' => $request->calculate_id
        ]);

        return response()->json([
            'message' => 'Producto registrado',
            'item' => $item
        ]);
    }

    function deleteProductCalculate(ProductCalculate $productCalculate)
    {
        $productCalculate->delete();
        return response()->json([
            'message' => 'Producto Eliminado'
        ]);
    }
}
