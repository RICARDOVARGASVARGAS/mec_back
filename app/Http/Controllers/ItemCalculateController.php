<?php

namespace App\Http\Controllers;

use App\Models\Calculate;
use App\Models\ItemCalculate;
use Illuminate\Http\Request;

class ItemCalculateController extends Controller
{
    function getListItemsCalculate(Calculate $calculate)
    {
        $items = $calculate->itemCalculates;
        $total = floatval($calculate->itemCalculates->sum(function ($product) {
            return $product->amount_item * $product->price_item;
        }));
        return response()->json([
            'calculate' => $calculate,
            'items' => $items,
            'total' => $total
        ]);
    }

    function registerItemCalculate(Request $request)
    {
        $request->validate([
            'amount_item' => ['required', 'numeric'],
            'description_item' => ['required', 'string'],
            'brand_item' => ['nullable', 'string'],
            'price_item' => ['required', 'numeric'],
            'calculate_id' => ['required', 'exists:calculates,id']
        ]);

        $item = ItemCalculate::create([
            'amount_item' => $request->amount_item,
            'description_item' => $request->description_item,
            'brand_item' => $request->brand_item,
            'price_item' => $request->price_item,
            'calculate_id' => $request->calculate_id
        ]);

        return response()->json([
            'message' => 'Item registrado',
            'item' => $item
        ]);
    }

    function deleteItemCalculate(ItemCalculate $itemCalculate)
    {
        $itemCalculate->delete();
        return response()->json([
            'message' => 'Item Eliminado'
        ]);
    }
}
