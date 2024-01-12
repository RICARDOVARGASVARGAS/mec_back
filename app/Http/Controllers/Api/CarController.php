<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CarResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\ExampleResource;
use App\Http\Resources\YearResource;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Client;
use App\Models\Color;
use App\Models\Example;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    function index(Request $request)
    {
        $items = Car::with(['client', 'example', 'color', 'brand', 'year'])
            ->where('plate', 'like', '%' . $request->search . '%')
            ->orWhere('engine', 'like', '%' . $request->search . '%')
            ->orWhere('chassis', 'like', '%' . $request->search . '%')
            ->orWhereRelation('client', 'document', 'like', '%' . $request->search . '%')
            ->orWhereRelation('client', 'name', 'like', '%' . $request->search . '%')
            ->orWhereRelation('client', 'surname', 'like', '%' . $request->search . '%')
            ->orWhereRelation('client', 'last_name', 'like', '%' . $request->search . '%')
            ->orWhereRelation('brand', 'name', 'like', '%' . $request->search . '%')
            ->orWhereRelation('example', 'name', 'like', '%' . $request->search . '%')
            ->orWhereRelation('year', 'name', 'like', '%' . $request->search . '%')
            ->orWhereRelation('color', 'name', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return CarResource::collection($items);
    }

    function create(Request $request)
    {
        $clients = Client::where('company_id', $request->company_id)->get();
        $examples = Example::where('company_id', $request->company_id)->get();
        $colors = Color::where('company_id', $request->company_id)->get();
        $brands = Brand::where('company_id', $request->company_id)->get();
        $years = Year::where('company_id', $request->company_id)->get();

        return response()->json([
            'clients' => ClientResource::collection($clients),
            'examples' => ExampleResource::collection($examples),
            'colors' => ColorResource::collection($colors),
            'brands' => BrandResource::collection($brands),
            'years' => YearResource::collection($years)
        ]);
    }

    function store(CarRequest $request)
    {
        $item = Car::create([
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

    function show(Car $car)
    {
        return CarResource::make($car);
    }

    function update(CarRequest $request, Car $car)
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

    function destroy(Car $car)
    {
        $car->delete();
        if ($car->image) {
            Storage::delete($car->image);
        }
        return CarResource::make($car)->additional([
            'message' => 'Vehículo Eliminado.'
        ]);
    }
}
