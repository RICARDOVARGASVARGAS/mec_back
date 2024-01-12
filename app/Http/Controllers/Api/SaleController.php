<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\CarResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\SaleResource;
use App\Models\Car;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    function index(Request $request)
    {
        $items = Sale::with(['client', 'car.client', 'car.color', 'car.brand', 'car.example', 'car.year', 'company'])->where('company_id', $request->company_id)
            ->where(function ($query) use ($request) {
                $query->where('entry_date', 'like', '%' . $request->search . '%')
                    ->orWhere('exit_date', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'document', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'surname', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('client', 'last_name', 'like', '%' . $request->search . '%')
                    ->orWhereRelation('car', 'plate', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'desc');
        $items = ($request->perPage == 'all') ? $items->get() : $items->paginate($request->perPage);

        return SaleResource::collection($items);
    }

    function create(Request $request)
    {
        $clients = Client::where('company_id', $request->company_id)->get();
        $cars = Car::with('client', 'example', 'year', 'brand', 'color')->whereRelation('client', 'company_id', $request->company_id)->get();

        return response()->json([
            'clients' => ClientResource::collection($clients),
            'cars' => CarResource::collection($cars)
        ]);
    }

    function store(SaleRequest $request)
    {
        $item = Sale::create([
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

    function show($sale)
    {
        $sale =  Sale::with(['services', 'products', 'client', 'car.client', 'car.color', 'car.brand', 'car.example', 'car.year', 'company'])->find($sale);
        // servicios
        $services = $sale->services;
        $totalServices = floatval($sale->services->sum('pivot.price_service'));
        // productos
        $products = $sale->products;
        $totalProducts = floatval($sale->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price_sell;
        }));

        // pagos
        $payments = Payment::with(['sale.company', 'box.company'])->where('sale_id', $sale->id)
            ->orderBy('id', 'desc')->get();
        $totalPayments = floatval($payments->sum('amount'));

        // Pendiente
        $pending = $totalServices + $totalProducts - ($totalPayments + $sale->discount);

        // Hacer que cambie de estado
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
            'data' => $sale,
            'sale' => $sale,
            'services' => $services,
            'totalServices' => $totalServices,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'payments' => $payments,
            'totalPayments' => $totalPayments,
            'pending' => $pending,
            'total' => $totalServices + $totalProducts,
        ]);
    }

    function update(SaleRequest $request, Sale $sale)
    {
        $sale->update([
            'km' => $request->km,
            'entry_date' => $request->entry_date,
            'exit_date' => $request->exit_date,
            'discount' => $request->discount,
            'status' => $request->status,
            'client_id' => $request->client_id,
            'car_id' => $request->car_id,
            'company_id' => $request->company_id
        ]);

        return SaleResource::make($sale)->additional([
            'message' => 'Venta Actualizada.'
        ]);
    }

    function destroy(Sale $sale)
    {
        $sale->delete();
        return SaleResource::make($sale)->additional([
            'message' => 'Venta Eliminada.'
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
            'res' => $request->all()
        ]);
    }

    function removeProduct(Request $request)
    {
        DB::table('product_sale')->where('id', $request->id)->delete();

        return response()->json([
            'res' => $request->all()
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
            'res' => $request->all()
        ]);
    }

    function removeService(Request $request)
    {
        DB::table('sale_service')->where('id', $request->id)->delete();

        return response()->json([
            'res' => $request->all()
        ]);
    }
}
