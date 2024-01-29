<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CarResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\ExampleResource;
use App\Http\Resources\SaleResource;
use App\Http\Resources\YearResource;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Client;
use App\Models\Color;
use App\Models\Example;
use App\Models\Sale;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    function getCars(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable', 'string', 'in:all'],
        ], [], ['company_id' => 'Mecánica', 'perPage' => 'Por Página', 'search' => 'Búsqueda']);

        $items = Car::whereRelation('client', 'company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('plate', 'like', '%' . $request->search . '%')
                    ->orWhere('engine', 'like', '%' . $request->search . '%')
                    ->orWhere('chassis', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'document', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'surname', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'last_name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('brand', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('example', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('year', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('color', 'name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);

        return CarResource::collection($items);
    }

    function registerCar(CarRequest $request)
    {
        $item = Car::create([
            'number' => Car::where('company_id', $request->company_id)->max('number') + 1,
            'plate' => $request->plate,
            'engine' => $request->engine,
            'chassis' => $request->chassis,
            'client_id' => $request->client_id,
            'example_id' => $request->example_id,
            'color_id' => $request->color_id,
            'brand_id' => $request->brand_id,
            'year_id' => $request->year_id
        ]);

        return CarResource::make($item)->additional([
            'message' => 'Vehículo Registrado.'
        ]);
    }

    function getCar($car)
    {
        $car = Car::included()->find($car);
        return CarResource::make($car);
    }

    function updateCar(CarRequest $request, Car $car)
    {
        $car->update([
            'plate' => $request->plate,
            'engine' => $request->engine,
            'chassis' => $request->chassis,
            'client_id' => $request->client_id,
            'example_id' => $request->example_id,
            'color_id' => $request->color_id,
            'brand_id' => $request->brand_id,
            'year_id' => $request->year_id
        ]);

        return CarResource::make($car)->additional([
            'message' => 'Vehículo Actualizado.'
        ]);
    }

    function deleteCar(Car $car)
    {
        try {
            $image = $car->image;
            DB::beginTransaction();
            $car->delete();
            DB::commit();
            if ($image) {
                Storage::delete($image);
            }
            return CarResource::make($car);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Obtener historial
    function getCarHistory($car)
    {
        $sales = Sale::where('car_id', $car)->orderBy('number', 'desc')->get();

        return SaleResource::collection($sales);
    }
}
