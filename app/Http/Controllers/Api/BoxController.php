<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoxRequest;
use App\Http\Resources\BoxResource;
use App\Http\Resources\MovementResource;
use App\Models\Box;
use App\Models\Movement;
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
            'number' => Box::where('company_id', $request->company_id)->max('number') + 1,
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

    // Detalle de caja
    function getDetailBox($box)
    {
        $box =  Box::included()->find($box);
        // movimientos
        $movements = $box->movements()->with(['client'])->orderBy('id', 'desc')->get();
        $totalMovements = floatval($movements->sum('amount'));

        // pagos
        $payments = $box->payments()->with(['sale'])->orderBy('id', 'desc')->get();
        $totalPayments = floatval($payments->sum('amount'));

        // Total de la caja
        $total = $totalMovements + $totalPayments;
        return response()->json([
            'box' => BoxResource::make($box),
            'movements' => $movements,
            'totalMovements' => $totalMovements,
            'payments' => $payments,
            'totalPayments' => $totalPayments,
            'total' => $total
        ]);
    }



    // Agregar movimientos
    function addMovement(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'detail' => ['required'],
            'date_movement' => ['required', 'date'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'box_id' => ['required', 'exists:boxes,id'],
        ], [], [
            'amount' => 'Monto del Movimiento',
            'detail' => 'Detalle del Movimiento',
            'date_movement' => 'Fecha del Movimiento',
            'client_id' => 'Cliente',
            'box_id' => 'Caja',
        ]);


        $item = Movement::create([
            'number' => Movement::where('box_id', $request->box_id)->max('number') + 1,
            'amount' => $request->amount,
            'detail' => $request->detail,
            'date_movement' => $request->date_movement,
            'client_id' => $request->client_id,
            'box_id' => $request->box_id
        ]);

        return MovementResource::make($item)->additional([
            'message' => 'Movimiento Registrado.',
        ]);
    }

    // Eliminar movimientos
    function removeMovement(Movement $movement)
    {
        $movement->delete();
        return MovementResource::make($movement)->additional([
            'message' => 'Movimiento Eliminado.',
        ]);
    }
}
