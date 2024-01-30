<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateRequest;
use App\Http\Resources\CalculateResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ServiceResource;
use App\Models\Calculate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalculateController extends Controller
{
    function getCalculates(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable'],
        ], [], ['company_id' => 'Mecánica', 'perPage' => 'Por Página', 'search' => 'Búsqueda']);

        $items = Calculate::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('number', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'document', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'surname', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'last_name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('car', 'plate', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);

        return CalculateResource::collection($items);
    }

    function registerCalculate(CalculateRequest $request)
    {
        $item = Calculate::create([
            'number' => Calculate::where('company_id', $request->company_id)->max('number') + 1,
            'client_id' => $request->client_id,
            'car_id' => $request->car_id,
            'company_id' => $request->company_id
        ]);

        return CalculateResource::make($item)->additional([
            'message' => 'Cotización Registrada.'
        ]);
    }

    function getCalculate($calculate)
    {
        $calculate = Calculate::included()->find($calculate);
        return CalculateResource::make($calculate);
    }

    function updateCalculate(CalculateRequest $request, Calculate $calculate)
    {
        $calculate->update([
            'client_id' => $request->client_id,
            'car_id' => $request->car_id,
            'company_id' => $request->company_id,
        ]);

        return CalculateResource::make($calculate)->additional([
            'message' => 'Cotización Actualizada.'
        ]);
    }

    function deleteCalculate(Calculate $calculate)
    {
        $calculate->delete();
        return response()->json([
            'message' => 'Cotización Eliminada.'
        ]);
    }

    // Detalle de Cotización
    function getCalculateDetail($calculate)
    {
        $calculate =  Calculate::included()->find($calculate);

        // servicios
        $services = $calculate->services;
        $totalServices = floatval($calculate->services->sum('pivot.price_service'));

        // productos
        $products = $calculate->products;
        $totalProducts = floatval($calculate->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price_sell;
        }));

        return response()->json([
            'calculate' => CalculateResource::make($calculate),
            'services' => ServiceResource::collection($services),
            'totalServices' => $totalServices,
            'products' => ProductResource::collection($products),
            'totalProducts' => $totalProducts,
            'total' => $totalServices + $totalProducts,
        ]);
    }

    // Productos
    function addProduct(Request $request)
    {
        $request->validate([
            'calculate_id' => 'required|exists:calculates,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'price_sell' => 'required|numeric|min:0',
        ], [], [
            'calculate_id' => 'Cotización',
            'product_id' => 'Producto',
            'quantity' => 'Cantidad',
            'price_sell' => 'Precio de Cotización',
        ]);

        $calculate = Calculate::find($request->calculate_id);

        $calculate->products()->attach([
            $request->product_id => [
                'quantity' => $request->quantity,
                'price_sell' => $request->price_sell,
            ]
        ]);

        return response()->json([
            'calculate' => $calculate,
            'message' => 'Producto Agregado'
        ]);
    }

    function removeProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:calculate_product,id'
        ], [], [
            'id' => 'ID'
        ]);
        DB::table('calculate_product')->where('id', $request->id)->delete();

        return response()->json([
            'res' => $request->all(),
            'message' => 'Producto eliminado'
        ]);
    }

    // Servicios
    function addService(Request $request)
    {
        $request->validate([
            'calculate_id' => 'required|exists:calculates,id',
            'service_id' => 'required|exists:services,id',
            'price_service' => 'required|numeric|min:0',
        ], [], [
            'calculate_id' => 'Cotización',
            'service_id' => 'Servicio',
            'price_service' => 'Precio de servicio',
        ]);

        $calculate = Calculate::find($request->calculate_id);

        $calculate->services()->attach([
            $request->service_id => [
                'price_service' => $request->price_service
            ]
        ]);

        return response()->json([
            'res' => $request->all(),
            'message' => 'Servicio agregado'
        ]);
    }

    function removeService(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:calculate_service,id'
        ], [], [
            'id' => 'ID'
        ]);
        DB::table('calculate_service')->where('id', $request->id)->delete();

        return response()->json([
            'res' => $request->all(),
            'message' => 'Servicio eliminado'
        ]);
    }
}
