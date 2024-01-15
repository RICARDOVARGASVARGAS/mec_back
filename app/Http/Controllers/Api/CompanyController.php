<?php

namespace App\Http\Controllers\Api;

use App\Data\Data;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    function registerCompany(Request $request)
    {
        $request->validate([
            'name_company' => 'required|string|min:3|max:50|unique:companies,name',
            'names' => 'required|string|min:3|max:50',
            'surnames' => 'required|string|min:3|max:50',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users,email',
        ], [], [
            'name_company' => 'Nombre de la Mecánica',
            'names' => 'Nombres',
            'surnames' => 'Apellidos',
            'phone' => 'Teléfono',
            'email' => 'Correo Electrónico',
        ]);

        // Registrando la empresa
        $company = Company::create([
            'name' => $request->name_company,
        ]);

        // Registrando el usuario
        $user = $company->users()->create([
            'names' => $request->names,
            'surnames' => $request->surnames,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make('MECSystem'),
        ]);

        // Asignando permisos
        $permissions = Permission::all();
        $user->permissions()->attach($permissions);

        // Respuesta
        return  response()->json([
            'message' => 'Cuenta registrada.',
            'user' => UserResource::make($user->load('permissions')),
            'company' => CompanyResource::make($company),
        ]);
    }

    // function index(Request $request)
    // {
    //     $items = Company::where('name', 'like', '%' . $request->search . '%')
    //         ->orWhere('email', 'like', '%' . $request->search . '%')
    //         ->orWhere('phone', 'like', '%' . $request->search . '%')
    //         ->orderBy('id', 'desc');

    //     $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

    //     return CompanyResource::collection($items);
    // }

    // function store(CompanyRequest $request)
    // {
    //     $item = Company::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //     ]);

    //     return CompanyResource::make($item)->additional([
    //         'message' => 'Empresa Registrada.'
    //     ]);
    // }

    // function show(Company $company)
    // {
    //     return CompanyResource::make($company);
    // }

    // function update(CompanyRequest $request, Company $company)
    // {
    //     $company->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //     ]);

    //     return CompanyResource::make($company)->additional([
    //         'message' => 'Empresa Actualizada.'
    //     ]);
    // }

    // function destroy(Company $company)
    // {
    //     $company->delete();

    //     return CompanyResource::make($company)->additional([
    //         'message' => 'Empresa Eliminada.'
    //     ]);
    // }


}
