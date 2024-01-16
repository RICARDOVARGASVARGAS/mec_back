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
    // Obtener datos de la Empresa
    function getCompany(Company $company)
    {
        return CompanyResource::make($company);
    }

    // Registrar la Empresa
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

    // Actualizar la Empresa
    function updateCompany(Company $company, Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50|unique:companies,name,' . $company->id,
        ], [], [
            'name' => 'Nombre de la Mecánica',
        ]);

        $company->update([
            'name' => $request->name,
        ]);

        // Respuesta
        return  response()->json([
            'message' => 'Mecánica actualizada.',
            'company' => CompanyResource::make($company),
        ]);
    }
}
