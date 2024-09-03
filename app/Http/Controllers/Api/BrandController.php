<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\ListRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    function getBrands(ListRequest $request)
    {
        $items = Brand::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc')
            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return BrandResource::collection($items);
    }

    function registerBrand(BrandRequest $request)
    {
        $item = Brand::create([
            'number' => Brand::where('company_id', $request->company_id)->max('number') + 1,
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return BrandResource::make($item)->additional([
            'message' => 'Marca Registrada.'
        ]);
    }

    function getBrand($brand)
    {
        $brand = Brand::included()->find($brand);
        return BrandResource::make($brand);
    }


    function updateBrand(BrandRequest $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return BrandResource::make($brand)->additional([
            'message' => 'Marca Actualizada.'
        ]);
    }

    function deleteBrand(Brand $brand)
    {
        $brand->delete();

        return BrandResource::make($brand)->additional([
            'message' => 'Marca Eliminada.'
        ]);
    }
}
