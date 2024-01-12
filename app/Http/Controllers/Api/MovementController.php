<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovementRequest;
use App\Http\Resources\MovementResource;
use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    function index(Request $request)
    {
        $items = Movement::with(['box', 'client'])->where('box_id', $request->box_id)
            ->where(function ($query) use ($request) {
                $query->where('detail', 'like', '%' . $request->search . '%')
                    ->orWhere('amount', 'like', '%' . $request->search . '%')
                    ->orWhere('date_movement', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('box', 'name', 'like', '%' . $request->search . '%');
            })->orderBy('date_movement', 'desc');
        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return MovementResource::collection($items);
    }

    function store(MovementRequest $request)
    {
        $item = Movement::create([
            'amount' => $request->amount,
            'detail' => $request->detail,
            'date_movement' => $request->date_movement,
            'client_id' => $request->client_id,
            'box_id' => $request->box_id
        ]);

        return MovementResource::make($item)->additional([
            'message' => 'Movimiento Registrado.'
        ]);
    }

    function destroy(Movement $movement)
    {
        $movement->delete();
        return MovementResource::make($movement)->additional([
            'message' => 'Movimiento Eliminado.'
        ]);
    }
}
