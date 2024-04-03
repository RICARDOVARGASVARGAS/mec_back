<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calculate;
use App\Models\ServiceCalculate;
use Illuminate\Http\Request;

class ServiceCalculateController extends Controller
{
    function getListServicesCalculate(Calculate $calculate)
    {
        $items = $calculate->serviceCalculates;
        $total = floatval($calculate->serviceCalculates->sum(function ($service) {
            return $service->price;
        }));
        return response()->json([
            'calculate' => $calculate,
            'items' => $items,
            'total' => $total
        ]);
    }

    function registerServiceCalculate(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'calculate_id' => ['required', 'exists:calculates,id']
        ], [], [
            'calculate_id' => 'Cotización',
            'description' => 'Descripción',
            'price' => 'Precio'
        ]);

        $item = ServiceCalculate::create([
            'description' => $request->description,
            'price' => $request->price,
            'calculate_id' => $request->calculate_id
        ]);

        return response()->json([
            'message' => 'Servicio registrado',
            'item' => $item
        ]);
    }

    function deleteServiceCalculate(ServiceCalculate $serviceCalculate)
    {
        $serviceCalculate->delete();
        return response()->json([
            'message' => 'Servicio Eliminado'
        ]);
    }
}
