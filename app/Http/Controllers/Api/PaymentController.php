<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    function index(Request $request)
    {
        $items = Payment::with(['sale.company', 'box.company'])->where('sale_id', $request->sale_id)
            ->where(function ($query) use ($request) {
                $query->where('detail', 'like', '%' . $request->search . '%')
                    ->orWhere('amount', 'like', '%' . $request->search . '%')
                    ->orWhere('date_payment', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('box', 'name', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');
        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return PaymentResource::collection($items);
    }

    function store(PaymentRequest $request)
    {
        $item = Payment::create([
            'detail' => $request->detail,
            'amount' => $request->amount,
            'date_payment' => $request->date_payment,
            'sale_id' => $request->sale_id,
            'box_id' => $request->box_id,
        ]);

        return PaymentResource::make($item)->additional([
            'message' => 'Pago Registrado.'
        ]);
    }

    function destroy(Payment $payment)
    {
        $payment->delete();
        return PaymentResource::make($payment)->additional([
            'message' => 'Pago Eliminado.'
        ]);
    }

    function getPayments(Request $request)
    {
        $items = Payment::with(['sale.company', 'box.company'])
            ->where('box_id', $request->box_id)
            ->orderBy('date_payment', 'desc')
            ->get();

        return response()->json([
            'data' => $items
        ]);
    }
}
