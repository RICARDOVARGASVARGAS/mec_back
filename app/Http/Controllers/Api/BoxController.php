<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoxRequest;
use App\Http\Resources\BoxResource;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoxController extends Controller
{
    function index(Request $request)
    {
        $items = Box::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return BoxResource::collection($items);
    }

    function store(BoxRequest $request)
    {
        $item = Box::create([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return BoxResource::make($item)->additional([
            'message' => 'Caja Registrada.'
        ]);
    }

    function show(Box $box)
    {
        return BoxResource::make($box);
    }

    function update(BoxRequest $request, Box $box)
    {
        $box->update([
            'name' => $request->name,
            'company_id' => $request->company_id
        ]);

        return BoxResource::make($box)->additional([
            'message' => 'Caja Actualizada.'
        ]);
    }

    function destroy(Box $box)
    {
        $box->delete();
        if ($box->image) {
            Storage::delete($box->image);
        }
        return BoxResource::make($box)->additional([
            'message' => 'Caja Eliminada.'
        ]);
    }
}
