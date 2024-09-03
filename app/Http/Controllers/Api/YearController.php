<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Http\Requests\YearRequest;
use App\Http\Resources\YearResource;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    function getYears(ListRequest $request)
    {
        $items = Year::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc')
            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return YearResource::collection($items);
    }

    function registerYear(YearRequest $request)
    {
        $item = Year::create([
            'number' => Year::where('company_id', $request->company_id)->max('number') + 1,
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return YearResource::make($item)->additional([
            'message' => 'Año Registrado.'
        ]);
    }

    function getYear($year)
    {
        $year = Year::included()->find($year);
        return YearResource::make($year);
    }


    function updateYear(YearRequest $request, Year $year)
    {
        $year->update([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return YearResource::make($year)->additional([
            'message' => 'Año Actualizado.'
        ]);
    }

    function deleteYear(Year $year)
    {
        $year->delete();

        return YearResource::make($year)->additional([
            'message' => 'Año Eliminado.'
        ]);
    }
}
