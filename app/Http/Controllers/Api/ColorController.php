<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    function getColors(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable', 'string', 'in:all'],
        ], [], ['company_id' => 'Mecánica']);

        $items = Color::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);

        return ColorResource::collection($items);
    }

    function registerColor(ColorRequest $request)
    {
        $item = Color::create([
            'name' => $request->name,
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
