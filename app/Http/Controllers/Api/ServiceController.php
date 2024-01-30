<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    function getServices(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable'],
        ], [], ['company_id' => 'Mecánica', 'perPage' => 'Por Página', 'search' => 'Búsqueda']);

        $items = Service::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('ticket', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);

        return ServiceResource::collection($items);
    }

    function registerService(ServiceRequest $request)
    {
        $item = Service::create([
            'number' => Service::where('company_id', $request->company_id)->max('number') + 1,
            'name' => $request->name,
            'ticket' => $request->ticket,
            'company_id' => $request->company_id
        ]);

        return ServiceResource::make($item)->additional([
            'message' => 'Servicio Registrado.'
        ]);
    }

    function getService($service)
    {
        $service = Service::included()->find($service);
        return ServiceResource::make($service);
    }

    function updateService(ServiceRequest $request, Service $service)
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

    function deleteService(Service $service)
    {
        try {
            $image = $service->image;
            DB::beginTransaction();
            $service->delete();
            DB::commit();
            if ($image) {
                Storage::delete($image);
            }
            return ServiceResource::make($service);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
