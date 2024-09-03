<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleRequest;
use App\Http\Requests\ListRequest;
use App\Http\Resources\ExampleResource;
use App\Models\Example;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    function getExamples(ListRequest $request)
    {
        $items = Example::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc')
            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return ExampleResource::collection($items);
    }

    function registerExample(ExampleRequest $request)
    {
        $item = Example::create([
            'number' => Example::where('company_id', $request->company_id)->max('number') + 1,
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return ExampleResource::make($item)->additional([
            'message' => 'Modelo Registrado.'
        ]);
    }

    function getExample($example)
    {
        $example = Example::included()->find($example);
        return ExampleResource::make($example);
    }


    function updateExample(ExampleRequest $request, Example $example)
    {
        $example->update([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return ExampleResource::make($example)->additional([
            'message' => 'Modelo Actualizado.'
        ]);
    }

    function deleteExample(Example $example)
    {
        $example->delete();

        return ExampleResource::make($example)->additional([
            'message' => 'Modelo Eliminado.'
        ]);
    }
}
