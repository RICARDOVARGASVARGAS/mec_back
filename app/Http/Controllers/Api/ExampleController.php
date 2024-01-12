<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleRequest;
use App\Http\Resources\ExampleResource;
use App\Models\Example;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    function index(Request $request)
    {
        $items = Example::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return ExampleResource::collection($items);
    }

    function store(ExampleRequest $request)
    {
        $item = Example::create([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return ExampleResource::make($item)->additional([
            'message' => 'Modelo Registrado.'
        ]);
    }

    function show(Example $example)
    {
        return ExampleResource::make($example);
    }

    function update(ExampleRequest $request, Example $example)
    {
        $example->update([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return ExampleResource::make($example)->additional([
            'message' => 'Modelo Actualizado.'
        ]);
    }

    function destroy(Example $example)
    {
        $example->delete();

        return ExampleResource::make($example)->additional([
            'message' => 'Modelo Eliminado.'
        ]);
    }
}
