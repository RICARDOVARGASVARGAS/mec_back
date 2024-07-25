<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SaleResource;
use App\Http\Resources\ServiceResource;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    function getSales(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable'],
            'status' => ['nullable', 'string', 'in:pending,done,cancelled,debt']
        ], [], ['company_id' => 'Mecánica', 'perPage' => 'Por Página', 'search' => 'Búsqueda']);

        $items = Sale::where('company_id', $request->company_id)
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->included()
            ->where(function ($query) use ($request) {
                $query->where('number', 'like', '%' . $request->search . '%')
                    ->orWhere('entry_date', 'like', '%' . $request->search . '%')
                    ->orWhere('exit_date', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('car.client', 'document', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('car.client', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('car.client', 'surname', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('car.client', 'last_name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('car', 'plate', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');

        $items = ($request->perPage == 'all' || $request->perPage == null) ? $items->get() : $items->paginate($request->perPage);

        return SaleResource::collection($items);
    }

    function registerSale(SaleRequest $request)
    {
        $item = Sale::create([
            'number' => Sale::where('company_id', $request->company_id)->max('number') + 1,
            'km' => $request->km,
            'entry_date' => $request->entry_date,
            'client_id' => $request->client_id,
            'car_id' => $request->car_id,
            'company_id' => $request->company_id
        ]);

        return SaleResource::make($item)->additional([
            'message' => 'Venta Registrada.'
        ]);
    }

    function getSale($sale)
    {
        $sale = Sale::included()->find($sale);
        return SaleResource::make($sale);
    }

    function updateSale(SaleRequest $request, Sale $sale)
    {
        $sale->update([
            'km' => $request->km,
            'entry_date' => $request->entry_date,
            'exit_date' => $request->exit_date,
            'payment_date' => $request->payment_date,
            'client_id' => $request->client_id,
            'car_id' => $request->car_id,
            'company_id' => $request->company_id,
            'status' => $request->status,
            'discount' => $request->discount,
            'observation' => $request->observation
        ]);

        return SaleResource::make($sale)->additional([
            'message' => 'Venta Actualizada.'
        ]);
    }

    function deleteSale(Sale $sale)
    {
        $sale->delete();
        return SaleResource::make($sale);
    }

    // Detalle de venta
    function getSaleDetail($sale)
    {
        $sale =  Sale::included()->find($sale);

        // servicios
        $services = $sale->services;
        $totalServices = floatval($sale->services->sum('pivot.price_service'));

        // productos
        $products = $sale->products;
        $totalProducts = floatval($sale->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price_sell;
        }));

        // pagos
        $payments = Payment::with(['box'])->where('sale_id', $sale->id)
            ->orderBy('id', 'desc')->get();
        $totalPayments = floatval($payments->sum('amount'));

        // Pendiente
        $pending = $totalServices + $totalProducts - ($totalPayments + $sale->discount);


        //     // Hacer que cambie de estado
        if ($sale->status == 'pending' || $sale->status == 'done') {
            if ($services->count() > 0 || $products->count() > 0) {
                if ($pending <= 0) {
                    $sale->update([
                        'status' => 'done'
                    ]);
                } else {
                    $sale->update([
                        'status' => 'pending'
                    ]);
                }
            }
        }


        return response()->json([
            'sale' => SaleResource::make($sale),
            'services' => ServiceResource::collection($services),
            'totalServices' => $totalServices,
            'products' => ProductResource::collection($products),
            'totalProducts' => $totalProducts,
            'payments' => PaymentResource::collection($payments),
            'totalPayments' => $totalPayments,
            'pending' => $pending,
            'total' => $totalServices + $totalProducts,
        ]);
    }


    // Productos
    function addProduct(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'price_buy' => 'required|numeric|min:0',
            'price_sell' => 'required|numeric|min:0',
            'date_sale' => 'required|date'
        ], [], [
            'sale_id' => 'Venta',
            'product_id' => 'Producto',
            'quantity' => 'Cantidad',
            'price_buy' => 'Precio de compra',
            'price_sell' => 'Precio de venta',
            'date_sale' => 'Fecha de venta'
        ]);

        $sale = Sale::find($request->sale_id);

        $sale->products()->attach([
            $request->product_id => [
                'quantity' => $request->quantity,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
                'date_sale' => $request->date_sale
            ]
        ]);

        return response()->json([
            'sale' => $sale,
            'message' => 'Producto Agregado'
        ]);
    }

    function removeProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:product_sale,id'
        ], [], [
            'id' => 'ID'
        ]);
        DB::table('product_sale')->where('id', $request->id)->delete();

        return response()->json([
            'res' => $request->all(),
            'message' => 'Producto eliminado'
        ]);
    }

    // Servicios
    function addService(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'service_id' => 'required|exists:services,id',
            'price_service' => 'required|numeric|min:0',
            'date_service' => 'required|date'
        ], [], [
            'sale_id' => 'Venta',
            'service_id' => 'Servicio',
            'price_service' => 'Precio de servicio',
            'date_service' => 'Fecha de servicio'
        ]);

        $sale = Sale::find($request->sale_id);

        $sale->services()->attach([
            $request->service_id => [
                'price_service' => $request->price_service,
                'date_service' => $request->date_service
            ]
        ]);

        return response()->json([
            'res' => $request->all(),
            'message' => 'Servicio agregado'
        ]);
    }

    function removeService(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sale_service,id'
        ], [], [
            'id' => 'ID'
        ]);
        DB::table('sale_service')->where('id', $request->id)->delete();

        return response()->json([
            'res' => $request->all(),
            'message' => 'Servicio eliminado'
        ]);
    }

    // Agregar Pagos
    function addPayment(Request $request)
    {
        $request->validate([
            'detail' => 'nullable',
            'amount' => 'required|numeric|min:0',
            'date_payment' => 'required|date',
            'sale_id' => 'required|exists:sales,id',
            'box_id' => 'required|exists:boxes,id',
        ], [], [
            'detail' => 'Detalle',
            'amount' => 'Monto de Pago',
            'date_payment' => 'Fecha de Pago',
            'sale_id' => 'Venta',
            'box_id' => 'Caja'
        ]);
        $item = Payment::create([
            'number' => Payment::where('box_id', $request->box_id)->max('number') + 1,
            'detail' => $request->detail,
            'amount' => $request->amount,
            'date_payment' => $request->date_payment,
            'sale_id' => $request->sale_id,
            'box_id' => $request->box_id,
        ]);

        return PaymentResource::make($item)->additional([
            'message' => 'Pago Registrado.',
        ]);
    }

    // Eliminar Pagos
    function removePayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id'
        ], [], [
            'payment_id' => 'Pago'
        ]);
        $payment = Payment::find($request->payment_id);
        $payment->delete();
        return PaymentResource::make($payment)->additional([
            'message' => 'Pago Eliminado.',
        ]);
    }

    // Reporte de Cajas de ganancias
    function getProfit(Request $request)
    {

        $request->validate([
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'company_id' => ['required', 'exists:companies,id']
        ], [], [
            'start_date' => 'Fecha de Inicio',
            'end_date' => 'Fecha de Fin',
            'company_id' => 'Mecánica'
        ]);

        $payments = Payment::with('box', 'sale')->whereRelation('sale', 'company_id', $request->company_id)
            ->whereRelation('sale', 'payment_date', '>=', $request->start_date)
            ->whereRelation('sale', 'payment_date', '<=', $request->end_date)
            ->get();

        // Sumar los pagos para cada venta
        $totalPayments = floatval($payments->sum('amount'));
        $chart = [];
        // Obtener el nombre de las cajas 
        $boxNames = $payments->pluck('box.name')->unique();

        foreach ($boxNames as $key => $value) {
            $chart[$value] = $payments->where('box.name', $value)->sum('amount');
        }

        $sales = Sale::where('company_id', $request->company_id)
            ->where('payment_date', '>=', $request->start_date)
            ->where('payment_date', '<=', $request->end_date)
            ->get();

        return response()->json([
            'sales' => $sales,
            'boxNames' => $boxNames,
            'totalPayments' => $totalPayments,
            'chart' => $chart,
            'payments' => $payments,
        ]);
    }

    // Obtener Ganancias
    // function getProfit(Request $request)
    // {
    //     $request->validate([
    //         'start_date' => ['required', 'date', 'before_or_equal:end_date'],
    //         'end_date' => ['required', 'date', 'after_or_equal:start_date'],
    //         'company_id' => ['required', 'exists:companies,id']
    //     ], [], [
    //         'start_date' => 'Fecha de Inicio',
    //         'end_date' => 'Fecha de Fin',
    //         'company_id' => 'Mecánica'
    //     ]);

    //     $sales = Sale::where('company_id', $request->company_id)->whereBetween('payment_date', [$request->start_date, $request->end_date])->get();

    //     // Sumar los pagos para cada venta
    //     $totalPayments = 0;
    //     foreach ($sales as $sale) {
    //         $totalPayments += $sale->payments()->sum('amount');
    //     }

    //     return response()->json([
    //         'sales' => $sales,
    //         'total_payments' => $totalPayments
    //     ]);

    //     return response()->json([
    //         'sales' => $sales
    //     ]);
    // }


}
