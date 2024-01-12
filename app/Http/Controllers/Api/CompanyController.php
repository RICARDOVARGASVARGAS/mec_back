<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function index(Request $request)
    {
        $items = Company::where('name', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%')
            ->orWhere('phone', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return CompanyResource::collection($items);
    }

    function store(CompanyRequest $request)
    {
        $item = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return CompanyResource::make($item)->additional([
            'message' => 'Empresa Registrada.'
        ]);
    }

    function show(Company $company)
    {
        return CompanyResource::make($company);
    }

    function update(CompanyRequest $request, Company $company)
    {
        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return CompanyResource::make($company)->additional([
            'message' => 'Empresa Actualizada.'
        ]);
    }

    function destroy(Company $company)
    {
        $company->delete();

        return CompanyResource::make($company)->additional([
            'message' => 'Empresa Eliminada.'
        ]);
    }
}
