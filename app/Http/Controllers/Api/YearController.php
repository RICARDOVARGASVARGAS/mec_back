<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\YearRequest;
use App\Http\Resources\YearResource;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    function index(Request $request)
    {
        $items = Year::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return YearResource::collection($items);
    }

    function store(YearRequest $request)
    {
        $item = Year::create([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return YearResource::make($item)->additional([
            'message' => 'Año Registrado.'
        ]);
    }

    function show(Year $year)
    {
        return YearResource::make($year);
    }

    function update(YearRequest $request, Year $year)
    {
        $year->update([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return YearResource::make($year)->additional([
            'message' => 'Año Actualizado.'
        ]);
    }

    function destroy(Year $year)
    {
        $year->delete();

        return YearResource::make($year)->additional([
            'message' => 'Año Eliminado.'
        ]);
    }
}
