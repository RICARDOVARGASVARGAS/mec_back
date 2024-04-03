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
                    ->orWhere('property_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('driver_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('ruc_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('dni_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('phone_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('cel_property_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('cel_driver_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('address_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('plate_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('engine_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('chassis_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('brand_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('model_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('year_car_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('color_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('km_calculate', 'like', '%' . $request->search . '%')
                    ->orWhere('observation_calculate', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);

        return CalculateResource::collection($items);
    }

    function registerCalculate(CalculateRequest $request)
    {
        $item = Calculate::create([
            'number' => Calculate::where('company_id', $request->company_id)->max('number') + 1,
            'property_calculate' => $request->property_calculate,
            'driver_calculate' => $request->driver_calculate,
            'ruc_calculate' => $request->ruc_calculate,
            'dni_calculate' => $request->dni_calculate,
            'phone_calculate' => $request->phone_calculate,
            'cel_property_calculate' => $request->cel_property_calculate,
            'cel_driver_calculate' => $request->cel_driver_calculate,
            'address_calculate' => $request->address_calculate,
            'plate_calculate' => $request->plate_calculate,
            'engine_calculate' => $request->engine_calculate,
            'chassis_calculate' => $request->chassis_calculate,
            'brand_calculate' => $request->brand_calculate,
            'model_calculate' => $request->model_calculate,
            'year_car_calculate' => $request->year_car_calculate,
            'color_calculate' => $request->color_calculate,
            'km_calculate' => $request->km_calculate,
            'observation_calculate' => $request->observation_calculate,
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

    function getCalculateDetail(Calculate $calculate)
    {
        $products = $calculate->productCalculates;
        $totalProducts = floatval($calculate->productCalculates->sum(function ($product) {
            return $product->amount * $product->price;
        }));
        $services = $calculate->serviceCalculates;
        $totalServices = floatval($calculate->serviceCalculates->sum(function ($service) {
            return $service->price;
        }));

        return response()->json([
            'products' => $products,
            'totalProducts' => $totalProducts,
            'services' => $services,
            'totalServices' => $totalServices,
            'calculate' => $calculate,
            'total' => $totalProducts + $totalServices
        ], 200);
    }

    function updateCalculate(CalculateRequest $request, Calculate $calculate)
    {
        $calculate->update([
            'property_calculate' => $request->property_calculate,
            'driver_calculate' => $request->driver_calculate,
            'ruc_calculate' => $request->ruc_calculate,
            'dni_calculate' => $request->dni_calculate,
            'phone_calculate' => $request->phone_calculate,
            'cel_property_calculate' => $request->cel_property_calculate,
            'cel_driver_calculate' => $request->cel_driver_calculate,
            'address_calculate' => $request->address_calculate,
            'plate_calculate' => $request->plate_calculate,
            'engine_calculate' => $request->engine_calculate,
            'chassis_calculate' => $request->chassis_calculate,
            'brand_calculate' => $request->brand_calculate,
            'model_calculate' => $request->model_calculate,
            'year_car_calculate' => $request->year_car_calculate,
            'color_calculate' => $request->color_calculate,
            'km_calculate' => $request->km_calculate,
            'observation_calculate' => $request->observation_calculate,
            'company_id' => $request->company_id
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
}
