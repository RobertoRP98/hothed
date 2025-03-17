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
                'po_status' => 'PENDIENTE DE PAGO',
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
    public function show($id, $requisicione)
    {
        // Validar que la orden de compra pertenece a la requisición
        $order = PurchaseOrder::with(['itemsOrderPurchase.product.tax', 'supplier', 'requisition'])
            ->where('id', $id)
            ->where('requisition_id', $requisicione) // Asegurar relación
            ->firstOrFail();

        $today = Carbon::now()->format('Y-m-d');
        //Datos para seleccionar
        $proveedor = Supplier::all();
        $producto = Product::all();
        $item = ItemOrderPurchase::all();

        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false));

        //inicializacion de datos
        $initialData = [
            'formData' => [
                'order' => $order->id,
                'requisition' => $order->requisition->id,
                'supplier_id' => $order->supplier_id,
                'type_op' => $order->type_op,
                'payment_type' => $order->payment_type,
                'unique_payment' => $order->unique_payment,
                'quotation' => $order->quotation,
                'currency' => $order->currency,
                'date_start' => $order->date_start,
                'finished' => $order->finished,
                'date_end' => $order->date_end,
                'payment_day' => $order->payment_day,
                'days_remaining_now' => $days_remaining_now,
                'status_requisition' => $order->requisition->status_requisition,
                'authorization_2' => $order->authorization_2,
                'authorization_3' => $order->authorization_3,
                'authorization_4' => $order->authorization_4,
                'delivery_condition' => $order->delivery_condition,
                'po_status' => $order->po_status,
                'bill' => $order->bill,
                'subtotal' => $order->subtotal,
                'total_descuento' => $order->total_descuento,
                'tax' => $order->tax,
                'total' => $order->total,
            ],

            'supplierData' => [
                [
                    'supplier_id' => $order->supplier->id ?? null, // Asegurar que no sea null
                    'name' => $order->supplier->name ?? '', // Nombre del proveedor
                    'rfc' => $order->supplier->rfc ?? '', // RFC del proveedor
                    'suggestions' => [],

                ]
            ],


            'productData' => $order->itemsOrderPurchase->map(function ($item) {
                return [
                    'product_id' => $item->product_id, // ✅ Se mantiene porque existe en items_order_purchase
                    'description' => optional($item->product)->description ?? 'Producto no encontrado', // ✅ Se obtiene de la relación product
                    'quantity' => $item->quantity, // ✅ De items_order_purchase
                    'price' => $item->price, // ✅ De items_order_purchase
                    'discount' => $item->discount, // ✅ De items_order_purchase
                    'subtotalproducto' => $item->subtotal, // ✅ De items_order_purchase
                    'udm' => optional($item->product)->udm ?? 'N/A', // ✅ Evitar errores si es null
                    'internal_id' => optional($item->product)->internal_id ?? 'N/A', // ✅ Evitar errores si es null
                    'tax' => [
                        'concept' => optional($item->product->tax)->concept ?? 'N/A',
                        'percentage' => optional($item->product->tax)->percentage ?? 0, // Si es null, envía 0
                    ],
                    'suggestions' => [],

                ];
            })->toArray(),
        ];

        //dd($initialData);



        // dd($initialData);
        return view('compras.show', compact('order', 'today', 'proveedor', 'producto', 'item', 'days_remaining_now', 'initialData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $requisicione)
    {
        //$order = PurchaseOrder::with(['itemsOrderPurchase.product.tax', 'supplier', 'requisition'])->findOrFail($id);

        // Validar que la orden de compra pertenece a la requisición
        $order = PurchaseOrder::with(['itemsOrderPurchase.product.tax', 'supplier', 'requisition'])
            ->where('id', $id)
            ->where('requisition_id', $requisicione) // Asegurar relación
            ->firstOrFail();

        $today = Carbon::now()->format('Y-m-d');
        //Datos para seleccionar
        $proveedor = Supplier::all();
        $producto = Product::all();
        $item = ItemOrderPurchase::all();

        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false));

        //inicializacion de datos
        $initialData = [
            'formData' => [
                'order' => $order->id,
                'requisition' => $order->requisition->id,
                'supplier_id' => $order->supplier_id,
                'type_op' => $order->type_op,
                'payment_type' => $order->payment_type,
                'unique_payment' => $order->unique_payment,
                'quotation' => $order->quotation,
                'currency' => $order->currency,
                'date_start' => $order->date_start,
                'finished' => $order->finished,
                'date_end' => $order->date_end,
                'payment_day' => $order->payment_day,
                'days_remaining_now' => $days_remaining_now,
                'status_requisition' => $order->requisition->status_requisition,
                'authorization_2' => $order->authorization_2,
                'authorization_3' => $order->authorization_3,
                'authorization_4' => $order->authorization_4,
                'delivery_condition' => $order->delivery_condition,
                'po_status' => $order->po_status,
                'bill' => $order->bill,
                'subtotal' => $order->subtotal,
                'total_descuento' => $order->total_descuento,
                'tax' => $order->tax,
                'total' => $order->total,
            ],

            'supplierData' => [
                [
                    'supplier_id' => $order->supplier->id ?? null, // Asegurar que no sea null
                    'name' => $order->supplier->name ?? '', // Nombre del proveedor
                    'rfc' => $order->supplier->rfc ?? '', // RFC del proveedor
                    'suggestions' => [],

                ]
            ],


            'productData' => $order->itemsOrderPurchase->map(function ($item) {
                return [
                    'product_id' => $item->product_id, // ✅ Se mantiene porque existe en items_order_purchase
                    'description' => optional($item->product)->description ?? 'Producto no encontrado', // ✅ Se obtiene de la relación product
                    'quantity' => $item->quantity, // ✅ De items_order_purchase
                    'price' => $item->price, // ✅ De items_order_purchase
                    'discount' => $item->discount, // ✅ De items_order_purchase
                    'subtotalproducto' => $item->subtotalproducto, // ✅ De items_order_purchase
                    'udm' => optional($item->product)->udm ?? 'N/A', // ✅ Evitar errores si es null
                    'internal_id' => optional($item->product)->internal_id ?? 'N/A', // ✅ Evitar errores si es null
                    'tax' => [
                        'concept' => optional($item->product->tax)->concept ?? 'N/A',
                        'percentage' => optional($item->product->tax)->percentage ?? 0, // Si es null, envía 0
                    ],
                    'suggestions' => [],

                ];
            })->toArray(),
        ];

        //dd($initialData);



        // dd($initialData);
        return view('compras.edit', compact('order', 'today', 'proveedor', 'producto', 'item', 'days_remaining_now', 'initialData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        try {
            Log::info('Datos recibidos en update:', $request->all());
            Log::info('Items recibidos:', $request->input('items_order'));

            // Validar que los productos existan en la BD
            $productIds = array_column($request->input('items_order', []), 'product_id');
            $validProductIds = Product::whereIn('id', $productIds)->pluck('id')->toArray();

            foreach ($productIds as $id) {
                if (!in_array($id, $validProductIds)) {
                    throw ValidationException::withMessages([
                        'items_order' => 'Uno o más productos seleccionados no son válidos.',
                    ]);
                }
            }

            DB::transaction(function () use ($request, $purchaseOrder) {
                // Actualizar los datos de la orden de compra
                $purchaseOrder->update(array_merge(
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
                        'authorization_4',
                        'delivery_condition',
                        'po_status',
                        'bill',
                    ]),
                    [
                        'requisition_id' => $purchaseOrder->requisition_id, // Asegurar que no se pierda
                        'subtotal' => $request->input('subtotal'),
                        'tax' => $request->input('total_impuestos'),
                        'total_descuento' => $request->input('total_descuento'),
                        'total' => $request->input('total'),
                        'date_start' => $request->input('date_start', Carbon::now()->format('Y-m-d'))
                    ]
                ));

                Log::info('Orden actualizada:', $purchaseOrder->toArray());

                // Eliminar los items anteriores y agregar los nuevos
                $purchaseOrder->itemsOrderPurchase()->delete();
                foreach ($request->input('items_order') as $item) {
                    ItemOrderPurchase::create([
                        'purchase_order_id' => $purchaseOrder->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'discount' => $item['discount'],
                        'subtotal' => $item['subtotalproducto']
                    ]);
                }
            });

            return response()->json([
                'message' => 'Orden de compra actualizada con éxito.',
                'redirect' => route('ordencompra.index')
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar orden de compra:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Ocurrió un error al actualizar la orden de compra. Intenta nuevamente.'
            ], 500);
        }

        dd($purchaseOrder);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }


    public function pdf($id, $requisicione)
    {
        // Validar que la orden de compra pertenece a la requisición
        $order = PurchaseOrder::with(['itemsOrderPurchase.product.tax', 'supplier', 'requisition'])
            ->where('id', $id)
            ->where('requisition_id', $requisicione) // Asegurar relación
            ->firstOrFail();

        $proveedorhh = Supplier::Where('id', 1)->first();

        $today = Carbon::now()->format('Y-m-d');
        //Datos para seleccionar
        $proveedor = Supplier::all();
        $producto = Product::all();
        $item = ItemOrderPurchase::all();

        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($order->requisition->production_date)->diffInDays(now(), false));

        //inicializacion de datos
        $initialData = [
            'formData' => [
                'order' => $order->id,
                'requisition' => $order->requisition->id,
                'supplier_id' => $order->supplier_id,
                'type_op' => $order->type_op,
                'payment_type' => $order->payment_type,
                'unique_payment' => $order->unique_payment,
                'quotation' => $order->quotation,
                'currency' => $order->currency,
                'date_start' => $order->date_start,
                'production_date' => $order->requisition->production_date,
                'finished' => $order->finished,
                'date_end' => $order->date_end,
                'payment_day' => $order->payment_day,
                'days_remaining_now' => $days_remaining_now,
                'status_requisition' => $order->requisition->status_requisition,
                'authorization_2' => $order->authorization_2,
                'authorization_3' => $order->authorization_3,
                'authorization_4' => $order->authorization_4,
                'delivery_condition' => $order->delivery_condition,
                'po_status' => $order->po_status,
                'bill' => $order->bill,
                'subtotal' => $order->subtotal,
                'total_descuento' => $order->total_descuento,
                'tax' => $order->tax,
                'total' => $order->total,
            ],

            'supplierData' => [
                [
                    'supplier_id' => $order->supplier->id ?? null, // Asegurar que no sea null
                    'name' => $order->supplier->name ?? '', // Nombre del proveedor
                    'address' => $order->supplier->address ?? '', // Nombre del proveedor
                    'account' => $order->supplier->account ?? '', // Nombre del proveedor
                    'rfc' => $order->supplier->rfc ?? '', // RFC del proveedor
                    'suggestions' => [],

                ]
            ],


            'productData' => $order->itemsOrderPurchase->map(function ($item) {
                return [
                    'product_id' => $item->product_id, // ✅ Se mantiene porque existe en items_order_purchase
                    'description' => optional($item->product)->description ?? 'Producto no encontrado', // ✅ Se obtiene de la relación product
                    'quantity' => $item->quantity, // ✅ De items_order_purchase
                    'price' => $item->price, // ✅ De items_order_purchase
                    'discount' => $item->discount, // ✅ De items_order_purchase
                    'subtotalproducto' => $item->subtotal, // ✅ De items_order_purchase
                    'udm' => optional($item->product)->udm ?? 'N/A', // ✅ Evitar errores si es null
                    'internal_id' => optional($item->product)->internal_id ?? 'N/A', // ✅ Evitar errores si es null
                    'tax' => [
                        'concept' => optional($item->product->tax)->concept ?? 'N/A',
                        'percentage' => optional($item->product->tax)->percentage ?? 0, // Si es null, envía 0
                    ],
                    'suggestions' => [],

                ];
            })->toArray(),
        ];

        //dd($initialData);



        // dd($initialData);
        return view('compras.pdf', compact('order', 'today', 'proveedor','proveedorhh', 'producto', 'item', 'days_remaining_now', 'initialData'));
    }
}
