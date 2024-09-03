<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ModuleResource;
use App\Http\Resources\UserResource;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    function getUsers(ListRequest $request)
    {
        $items = User::with(['company'])->where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('names', 'like', '%' . $request->search . '%')
                    ->orWhere('surnames', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($request->perPage, ['*'], 'page', $request->page);


        return UserResource::collection($items);
    }

    function registerUser(UserRequest $request)
    {
        $item = User::create([
            'number' => User::where('company_id', $request->company_id)->max('number') + 1,
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
        try {
            $image = $user->image;
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            if ($image) {
                Storage::delete($image);
            }
            return UserResource::make($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
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
