<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Http\Requests\ListRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    function getColors(ListRequest $request)
    {
        $items = Color::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage, ['*'], 'page', $request->page);

        return ColorResource::collection($items);
    }

    function registerColor(ColorRequest $request)
    {
        $item = Color::create([
            'number' => Color::where('company_id', $request->company_id)->max('number') + 1,
            'name' => $request->name,
            'hex' => $request->hex,
            'company_id' => $request->company_id
        ]);

        return ColorResource::make($item)->additional([
            'message' => 'Color Registrado.'
        ]);
    }

    function getColor($color)
    {
        $color = Color::included()->find($color);
        return ColorResource::make($color);
    }


    function updateColor(ColorRequest $request, Color $color)
    {
        $color->update([
            'name' => $request->name,
            'hex' => $request->hex,
            'company_id' => $request->company_id
        ]);

        return ColorResource::make($color)->additional([
            'message' => 'Color Actualizado.'
        ]);
    }

    function deleteColor(Color $color)
    {
        $color->delete();

        return ColorResource::make($color)->additional([
            'message' => 'Color Eliminado.'
        ]);
    }
}
