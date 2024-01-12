<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    function index(Request $request)
    {
        $items = Brand::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return BrandResource::collection($items);
    }

    function store(BrandRequest $request)
    {
        $item = Brand::create([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return BrandResource::make($item)->additional([
            'message' => 'Marca Registrada.'
        ]);
    }

    function show(Brand $brand)
    {
        return BrandResource::make($brand);
    }

    function update(BrandRequest $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return BrandResource::make($brand)->additional([
            'message' => 'Marca Actualizada.'
        ]);
    }

    function destroy(Brand $brand)
    {
        $brand->delete();

        return BrandResource::make($brand)->additional([
            'message' => 'Marca Eliminada.'
        ]);
    }
}
