<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    function index(Request $request)
    {
        $items = Service::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('ticket', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return ServiceResource::collection($items);
    }

    function store(ServiceRequest $request)
    {
        $item = Service::create([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'company_id' => $request->company_id
        ]);

        return ServiceResource::make($item)->additional([
            'message' => 'Servicio Registrado.'
        ]);
    }

    function show(Service $service)
    {
        return ServiceResource::make($service);
    }

    function update(ServiceRequest $request, Service $service)
    {
        $service->update([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'company_id' => $request->company_id
        ]);

        return ServiceResource::make($service)->additional([
            'message' => 'Servicio Actualizado.'
        ]);
    }

    function destroy(Service $service)
    {
        $service->delete();
        if ($service->image) {
            Storage::delete($service->image);
        }
        return ServiceResource::make($service)->additional([
            'message' => 'Servicio Eliminado.'
        ]);
    }
}
