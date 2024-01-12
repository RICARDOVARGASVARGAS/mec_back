<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    function index(Request $request)
    {
        $items = Client::where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('document', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('surname', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return ClientResource::collection($items);
    }

    function store(ClientRequest $request)
    {
        $item = Client::create([
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

    function show(Client $client)
    {
        return ClientResource::make($client);
    }

    function update(ClientRequest $request, Client $client)
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

    function destroy(Client $client)
    {
        $client->delete();
        if ($client->image) {
            Storage::delete($client->image);
        }
        return ClientResource::make($client)->additional([
            'message' => 'Cliente Eliminado.'
        ]);
    }
}
