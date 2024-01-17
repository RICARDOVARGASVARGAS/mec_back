<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Http\Resources\ModuleResource;
use App\Http\Resources\UserResource;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    function getUsers(Request $request)
    {

        $request->validate([
            'search' => 'nullable',
            'perPage' => 'nullable|numeric',
            'company' => 'required|exists:companies,id'
        ], [], [
            'search' => 'Búsqueda',
            'perPage' => 'Registros por página',
            'company' => 'Mecánica'
        ]);

        $items = User::with(['company'])->where('company_id', $request->company)
            ->where(function ($query) use ($request) {
                $query->where('names', 'like', '%' . $request->search . '%')
                    ->orWhere('surnames', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);
        return UserResource::collection($items);
    }

    function registerUser(UserRequest $request)
    {
        $item = User::create([
            'names' => $request->names,
            'surnames' => $request->surnames,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 'active',
            'role' => 'user',
            'password' => bcrypt('MECSystem'),
            'company_id' => $request->company_id
        ]);

        return UserResource::make($item)->additional([
            'message' => 'Administrador Registrado.'
        ]);
    }

    function getUser($user)
    {
        $user = User::included()->find($user);
        return UserResource::make($user);
    }

    function updateUser(UserRequest $request, User $user)
    {
        $user->update([
            'names' => $request->names,
            'surnames' => $request->surnames,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
            'company_id' => $request->company_id
        ]);

        return UserResource::make($user)->additional([
            'message' => 'Administrador Actualizado.'
        ]);
    }

    function deleteUser(User $user)
    {
        $user->delete();
        if ($user->image) {
            Storage::delete($user->image);
        }
        return UserResource::make($user)->additional([
            'message' => 'Administrador Eliminado.'
        ]);
    }

    function resetPassword(User $user)
    {
        $user->update([
            'password' => bcrypt('MECSystem')
        ]);

        return UserResource::make($user)->additional([
            'message' => 'Contraseña Restablecida.'
        ]);
    }

    function changePassword(Request $request, User $user)
    {
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return UserResource::make($user)->additional([
            'message' => 'Contraseña Cambiada.'
        ]);
    }

    function updatePermission(Request $request)
    {
        $user = User::find($request->user_id);
        if ($request->permissions == null) {
            $user->permissions()->detach();
        } else {
            $user->permissions()->sync(explode(",", $request->permissions));
        }

        return response()->json([
            'user' => $user,
            'permissions' => $request->permissions,
            'message' => 'Permisos actualizados correctamente'
        ]);
    }

    function getModules()
    {
        $items = Module::with(['permissions'])->get();
        return ModuleResource::collection($items);
    }
}
