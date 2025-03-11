<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Requisition;
use App\Models\PurchaseOrder;
use App\Models\ItemOrderPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datosoc = PurchaseOrder::all();
        return view('compras.index', compact('datosoc'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($requisicionId)
    {
        $today = Carbon::now()->format('Y-m-d');

        //Buscar la requisicion
        $requisicion = Requisition::findOrFail($requisicionId);
        //Datos para seleccionar
        $proveedor = Supplier::all();
        $producto = Product::all();
        $item = ItemOrderPurchase::all();

        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($requisicion->production_date)->diffInDays(now(), false));

        //inicializacion de datos
        $initialData = [
            'formData' => [
                'requisition_id' => $requisicion->id,
                'supplier_id' => 1,
                'type_op' => 'Local',
                'payment_type' => 'TRANSFERENCIA',
                'unique_payment' => 0,
                'quotation' => '',
                'currency' => 'MXN',
                'date_start' => $today,
                'finished' => 0,
                'date_end' => '',
                'payment_day' => '',
                'days_remaining_now' => $days_remaining_now,
                'status_requisition' => $requisicion->status_requisition,
                'authorization_2' => 'Pendiente',
                'authorization_3' => 'Pendiente',
                'authorization_4' => 'Pendiente',
                'delivery_condition' => '100% Antes Entrega',
                'po_status' => 'Pendiente de Pago',
                'bill' => 'Pendiente Facturar',
                'subtotal' => 0,
                'total_descuento' => 0,
                'tax' => 0,
                'total' => 0,
            ],

            'supplierData' => [],
        ];


        // dd($initialData);

        return view('compras.create', compact('requisicion', 'proveedor', 'producto', 'item', 'initialData', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {

        try {
            Log::info('Datos recibidos:', $request->all());
            Log::info('Items recibidos:', $request->input('items_order'));

            // Validar que todos los IDs sean válidos
            $productIds = array_column($request->input('items_requisition', []), 'product_id');
            $validProductIds = Product::whereIn('id', $productIds)->pluck('id')->toArray();

            foreach ($productIds as $id) {
                if (!in_array($id, $validProductIds)) {
                    throw ValidationException::withMessages([
                        'items_requisition' => 'Uno o más productos seleccionados no son válidos.',
                    ]);
                }
            }

            DB::transaction(function () use ($request) {

                $today = Carbon::now()->format('Y-m-d');

                //asignar valores del front al back

                $order = PurchaseOrder::create(array_merge(
                    $request->only([
                        'requisition_id',
                        'supplier_id',
                        'type_op',
                        'payment_type',
                        'unique_payment',
                        'quotation',
                        'currency',
                        'finished',
                        'date_end',
                        'payment_day',
                        'authorization_2',
                        'authorization_4' => $request->input('authorization_4'),
                        'delivery_condition',
                        'po_status',
                        'bill',

                    ]),
                    [
                        'subtotal' => $request->input('subtotal'),
                        'tax' => $request->input('total_impuestos'),
                        'total_descuento' => $request->input('total_descuento'),
                        'total' => $request->input('total'),
                        'date_start' => $request->input('date_start', $today)
                    ]
                ));

                //gaurdar los items de la orden
                Log::info('Datos de la orden antes de crear:', $order->toArray()); // Depuración


                foreach ($request->input('items_order') as $item) {
                    ItemOrderPurchase::create([
                        'purchase_order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'discount' => $item['discount'],
                        'subtotal' => $item['subtotalproducto']
                    ]);
                }
            });

            return response()->json([
                'message' => 'Orden de compra creada con éxito.',
                'redirect' => route('ordencompra.index')
            ]);
        } catch (\Exception $e) {
            Log::error('Error al crear orden de compra:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Ocurrió un error inesperado al guardar la orden de compra. Por favor, inténtalo nuevamente.'
            ], 500);
        }

        Log::info('Valores recibidos en Laravel:', $request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
