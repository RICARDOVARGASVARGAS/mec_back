<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    function index(Request $request)
    {
        $items = Color::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('hex', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return ColorResource::collection($items);
    }

    function store(ColorRequest $request)
    {
        $item = Color::create([
            'name' => $request->name,
            'hex' => $request->hex,
            'company_id' => $request->company_id
        ]);

        return ColorResource::make($item)->additional([
            'message' => 'Color Registrado.'
        ]);
    }

    function show(Color $color)
    {
        return ColorResource::make($color);
    }

    function update(ColorRequest $request, Color $color)
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

    function destroy(Color $color)
    {
        $color->delete();

        return ColorResource::make($color)->additional([
            'message' => 'Color Eliminado.'
        ]);
    }
}
