<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoxRequest;
use App\Http\Resources\BoxResource;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BoxController extends Controller
{
    function getBoxes(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable', 'string', 'in:all'],
        ], [], ['company_id' => 'Mecánica', 'perPage' => 'Por Página', 'search' => 'Búsqueda']);

        $items = Box::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);

        return BoxResource::collection($items);
    }

    function registerBox(BoxRequest $request)
    {
        $item = Box::create([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'company_id' => $request->company_id
        ]);

        return BoxResource::make($item)->additional([
            'message' => 'Servicio Registrado.'
        ]);
    }

    function getBox($box)
    {
        $box = Box::included()->find($box);
        return BoxResource::make($box);
    }

    function updateBox(BoxRequest $request, Box $box)
    {
        $box->update([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'company_id' => $request->company_id
        ]);

        return BoxResource::make($box)->additional([
            'message' => 'Servicio Actualizado.'
        ]);
    }

    function deleteBox(Box $box)
    {
        try {
            $image = $box->image;
            DB::beginTransaction();
            $box->delete();
            DB::commit();
            if ($image) {
                Storage::delete($image);
            }
            return BoxResource::make($box);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
