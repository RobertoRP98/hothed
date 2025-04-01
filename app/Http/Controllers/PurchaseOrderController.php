<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\OcPreaut;
use App\Models\Product;
use App\Mail\OcAuthMail;
use App\Models\Supplier;
use App\Mail\TrackingMail;
use App\Models\Requisition;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ItemOrderPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        $datosoc = PurchaseOrder::query()
            ->where('authorization_4', 'Autorizado')
            ->get();

        return view('compras.index', compact('datosoc'));
    }

    public function indexpend()
    {
        $datosoc = PurchaseOrder::query()
            ->where('authorization_4', 'Pendiente')
            ->get();

        return view('compras.pendientes', compact('datosoc'));
    }

    public function indexcanc()
    {
        $datosoc = PurchaseOrder::query()
            ->where('authorization_4', 'Rechazado')
            ->get();

        return view('compras.rechazadas', compact('datosoc'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($requisicionId)
    {
        $today = Carbon::now()->format('Y-m-d');

        //Buscar la requisicion
        // $requisicion = Requisition::findOrFail($requisicionId);
        $requisicion = Requisition::with('itemsRequisition.product.tax')->findOrFail($requisicionId);

        //Datos para seleccionar
        $proveedor = Supplier::all();
        $producto = Product::all();
        $item = ItemOrderPurchase::all();

        // Obtener productos de la requisición
        $productosRequisicion = $requisicion->itemsRequisition->map(function ($item) {
            return [
                'product_id' => $item->product_id ?? '', // Ahora toma el ID correcto del producto
                //'internal_id' => $item->product->internal_id ?? '', // Código interno del producto
                'category' => $item->product->category ?? '',
                'udm' => $item->product->udm ?? '', // Unidad de medida
                'quantity' => $item->quantity, // Cantidad del producto en la requisición
                'price' => '', // Lo completará el comprador
                'description' => $item->product->description ?? '', // 👈 Agrega esto
                'discount' => 0, // Se llenará después
                'subtotalproducto' => '', // Se calculará después
                'suggestions' => [], // Espacio para autocompletado si se requiere
                'tax' => [
                    'concept' => optional($item->product->tax)->concept ?? 'N/A',
                    'percentage' => optional($item->product->tax)->percentage ?? 0, // Si es null, envía 0
                ],
            ];
        });


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
                'bill_name' => '',
                'subtotal' => 0,
                'total_descuento' => 0,
                'tax' => 0,
                'total' => 0,
            ],
            'productData' => $productosRequisicion, // 🔥 Aquí pasamos los productos
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


            DB::transaction(function () use ($request, &$orden) {

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
                        'bill_name',


                    ]),
                    [
                        'subtotal' => $request->input('subtotal'),
                        'tax' => $request->input('total_impuestos'),
                        'total_descuento' => $request->input('total_descuento'),
                        'total' => $request->input('total'),
                        'date_start' => $request->input('date_start', $today)
                    ]
                ));

                $orden = $order; // Aquí se asigna correctamente

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



            Log::info('Estado de la orden después de la transacción:', [
                'order' => $orden,
                'status' => $orden->authorization_2
            ]);

            // Definir correos
            $emails = [
                'ADM' => 'bianca.fernanda.rebolledo@hothedmex.mx',
                'OP' => 'alejandro.flores@hothedmex.mx'
            ];

            //ENVIAR EL CORREO SI APLICA

            if ($orden && $orden->authorization_2 == 'Pendiente') {
                $departamento = $orden->requisition->user->departament;
                $correoDestino = $emails[$departamento] ?? null;

                if ($correoDestino) {
                    Log::info('Enviando correo a:', ['email' => $correoDestino]);
                    Mail::to($correoDestino)->send(new OcPreaut($orden));
                } else {
                    Log::warning('No se encontró un correo para el departamento:', ['departamento' => $departamento]);
                }
            } else {
                Log::warning('No se envió el correo porque la orden no está pendiente o no existe.', [
                    'orden' => $orden,
                ]);
            }

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
                'bill_name' => $order->bill_name,
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
                    //'internal_id' => optional($item->product)->internal_id ?? 'N/A', // ✅ Evitar errores si es null
                    'category' => $item->product->category ?? '',
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
                'bill_name' => $order->bill_name,

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
                    //'internal_id' => optional($item->product)->internal_id ?? 'N/A', // ✅ Evitar errores si es null
                    'category' => $item->product->category ?? '',

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

            //  Inicializar fuera del transaction para poder usarla después
            $orden = null;

            DB::transaction(function () use ($request, $purchaseOrder, &$orden) {
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
                        'bill_name',
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

                // Recargar orden actualizada
                $orden = $purchaseOrder->fresh();
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

            // Verifica si $orden es null
            if (!$orden) {
                Log::error('La orden de compra es NULL después de la transacción.');
                return;
            }

            // Verificar estado de la orden después de la transacción
            Log::info('Estado de la orden después de la transacción:', [
                'order_id' => $orden->id ?? 'NULL',
                'status' => $orden->authorization_2 ?? 'NULL'
            ]);

            // Definir correos - De momento es solo la directora pero si requiere ayuda se deja abierto al departamento
            $emails = [
                'ADM' => 'karla.ibeth.segura@hothedmex.mx',
                'OP' => 'karla.ibeth.segura@hothedmex.mx'
            ];

            // ENVIAR EL CORREO SI APLICA
            if ($orden->authorization_2 && ($orden->authorization_2) == 'Autorizado') {
                // Verifica si la requisición existe antes de acceder a user->departament
                if (!$orden->requisition || !$orden->requisition->user) {
                    Log::error('La orden no tiene una requisición válida o no tiene usuario asignado.', [
                        'order_id' => $orden->id
                    ]);
                    return;
                }

                $departamento = $orden->requisition->user->departament ?? 'NULL';
                $correoDestino = $emails[$departamento] ?? null;

                if ($correoDestino) {
                    Log::info('Enviando correo a:', ['email' => $correoDestino]);
                    Mail::to($correoDestino)->send(new OcAuthMail($orden));
                } else {
                    Log::warning('No se encontró un correo para el departamento:', ['departamento' => $departamento]);
                }
            } else {
                Log::warning('No se envió el correo porque la orden no está en estado "Pendiente".', [
                    'order_id' => $orden->id,
                    'authorization_2' => $orden->authorization_2
                ]);
            }


            //  Si la Orden ya fue autorizada por direccion
            if ($orden && $orden->authorization_4 == 'Autorizado') {


                $emails = [
                    'bianca.fernanda.rebolledo@hothedmex.mx',
                    //agrega mas correos si hay mas responsables de compras
                ];

                Log::info('Enviando correo a:', ['emails' => $emails]);
                Mail::to($emails)->send(new TrackingMail($orden));
            }




            $message = "Requisición creada con éxito";

            // Definir redirecciones por rol
            $roleRedirects = [
                'Developer' => '/ordenes-compra',
                'RespCompras' => '/ordenes-compra',
                'Gerope' => '/ordenes-compra/pre-autorizacio/ope/autorizadas',
                'Diradmin' => '/ordenes-compra/autorizacion/autorizadas',
            ];

            // Obtener la ruta correspondiente según el rol del usuario
            foreach ($roleRedirects as $role => $redirect) {
                if (auth()->user()->hasRole($role)) {
                    return response()->json([
                        'message' => $message,
                        'redirect' => $redirect,
                    ]);
                }
            }


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

        // dd($purchaseOrder);
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

        // Calcular prioridad con la misma lógica de Blade
        $priority = 'BAJA';
        if ($days_remaining_now >= -15) {
            $priority = 'ALTA';
        } elseif ($days_remaining_now >= -30) {
            $priority = 'ALTA';
        } elseif ($days_remaining_now >= -60) {
            $priority = 'MEDIA';
        }

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
                'prioridad' => $priority,
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
                'proyecto' => $order->requisition->notes_client,
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
                    'category' => $item->product->category ?? '',

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

        $pdf = Pdf::loadview('compras.pdf', compact('order', 'today', 'proveedor', 'proveedorhh', 'producto', 'item', 'days_remaining_now', 'initialData'));
        return $pdf->download('Orden de compra - ' . $initialData['formData']['order'] . '.pdf');
    }
}
