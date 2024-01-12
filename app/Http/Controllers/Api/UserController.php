<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    function index(Request $request)
    {
        $items = User::with(['permissions', 'company'])->where('company_id', $request->company_id)
            ->where('visible', 'public')
            ->where(function ($query) use ($request) {
                $query->where('names', 'like', '%' . $request->search . '%')
                    ->orWhere('surnames', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return UserResource::collection($items);
    }

    function store(UserRequest $request)
    {
        $item = User::create([
            'names' => $request->names,
            'surnames' => $request->surnames,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 'active',
            'password' => bcrypt('mecweb'),
            'company_id' => $request->company_id
        ]);

        return UserResource::make($item)->additional([
            'message' => 'Usuario Registrado.'
        ]);
    }

    function show(User $user)
    {
        return UserResource::make($user);
    }

    function update(UserRequest $request, User $user)
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
            'message' => 'Usuario Actualizado.'
        ]);
    }

    function destroy(User $user)
    {
        $user->delete();
        if ($user->image) {
            Storage::delete($user->image);
        }
        return UserResource::make($user)->additional([
            'message' => 'Usuario Eliminado.'
        ]);
    }

    function resetPassword(User $user)
    {
        $user->update([
            'password' => bcrypt('mecweb')
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
        $user->permissions()->sync(explode(",", $request->permissions));
        return response()->json([
            'user' => $user,
            'permissions' => $request->permissions,
            'message' => 'Permisos actualizados correctamente'
        ]);
    }
}
