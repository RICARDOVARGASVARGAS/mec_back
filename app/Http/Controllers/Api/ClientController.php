<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\ListRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    function getClients(ListRequest $request)
    {
        $items = Client::where('company_id', $request->company_id)
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('document', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('surname', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc')->paginate($request->perPage, ['*'], 'page', $request->page);

        return ClientResource::collection($items);
    }

    function registerClient(ClientRequest $request)
    {
        $item = Client::create([
            'number' => Client::where('company_id', $request->company_id)->max('number') + 1,
            'document' => $request->document,
            'name' => $request->name,
            'surname' => $request->surname,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => $request->company_id
        ]);

        return ClientResource::make($item)->additional([
            'message' => 'Cliente Registrado.'
        ]);
    }

    function getClient($client)
    {
        $client = Client::included()->find($client);
        return ClientResource::make($client);
    }

    function updateClient(ClientRequest $request, Client $client)
    {
        $client->update([
            'document' => $request->document,
            'name' => $request->name,
            'surname' => $request->surname,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => $request->company_id
        ]);

        return ClientResource::make($client)->additional([
            'message' => 'Cliente Actualizado.'
        ]);
    }

    function deleteClient(Client $client)
    {
        try {
            $image = $client->image;
            DB::beginTransaction();
            $client->delete();
            DB::commit();
            if ($image) {
                Storage::delete($image);
            }
            return ClientResource::make($client);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
