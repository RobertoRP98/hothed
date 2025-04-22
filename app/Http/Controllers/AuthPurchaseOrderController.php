<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\ItemOrderPurchase;


class AuthPurchaseOrderController extends Controller
{
    public function indexpendienteadm()
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $datosoc = PurchaseOrder::query()
            ->whereHas('requisition.user', function ($query) {
                $query->where('departament', 'ADM');
            })
            ->where('authorization_2', 'Pendiente')
            ->get();

        return view('compraspreaut.adm.pendienteadm', compact('datosoc'));
    }

    public function indextautorizadoadm()
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $datosoc = PurchaseOrder::query()
            ->whereHas('requisition.user', function ($query) {
                $query->where('departament', 'ADM');
            })
            ->where('authorization_2', 'Autorizado')
            ->get();

        return view('compraspreaut.adm.autorizadoadm', compact('datosoc'));
    }

    public function indexrechazadoadm()
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $datosoc = PurchaseOrder::query()
            ->whereHas('requisition.user', function ($query) {
                $query->where('departament', 'ADM');
            })
            ->where('authorization_2', 'Rechazado')
            ->get();

        return view('compraspreaut.adm.rechazadoadm', compact('datosoc'));
    }
    //TERMINAN INDEX DE ADMINISTRACIÓN

    //EMPIEZAN INDEX DE OPERACIONES
    public function indexpendienteope()
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin', 'Gerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $datosoc = PurchaseOrder::query()
            ->whereHas('requisition.user', function ($query) {
                $query->where('departament', 'OP');
            })
            ->where('authorization_2', 'Pendiente')
            ->get();

        return view('compraspreaut.ope.pendienteope', compact('datosoc'));
    }

    public function indextautorizadoope()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin', 'Gerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }


        $datosoc = PurchaseOrder::query()
            ->whereHas('requisition.user', function ($query) {
                $query->where('departament', 'OP');
            })
            ->where('authorization_2', 'Autorizado')
            ->get();

        return view('compraspreaut.ope.autorizadoope', compact('datosoc'));
    }

    public function indexrechazadoope()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin', 'Gerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }


        $datosoc = PurchaseOrder::query()
            ->whereHas('requisition.user', function ($query) {
                $query->where('departament', 'OP');
            })
            ->where('authorization_2', 'Rechazado')
            ->get();

        return view('compraspreaut.ope.rechazadoope', compact('datosoc'));
    }
    //FIN INDEXES DE PRE AUTORIZACIONES

    //EDIT PRE AUTORIZACIONES

    public function editpreaut($id, $requisicione)
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin', 'Gerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

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
        return view('compraspreaut.editpreaut', compact('order', 'today', 'proveedor', 'producto', 'item', 'days_remaining_now', 'initialData'));
    }

    //TERMINAN EDIT DE PRE AUTORIZACION




    //EMPIEZAN AUTORIZACIONES DE LA DIRECTORA GENERAL Y RESP < 15K - DOBLE CANDADO DE ACCESO A LAS RUTAS

    public function indexpendientedir()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin','Contamex'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $datosoc = PurchaseOrder::query()
            ->where('authorization_4', 'Pendiente')
            ->where('total', '>=', 15000)
            ->get();

        return view('comprasdir.pendientedir', compact('datosoc'));
    }

    public function indexpendienteresp()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin','Contamex'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $datosoc = PurchaseOrder::query()
            ->where('authorization_4', 'Pendiente')
            ->where('total', '<', 15000)
            ->get();

        return view('comprasdir.pendienteresp', compact('datosoc'));
    }

    public function indextautorizadodir()
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin', 'Contamex'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }


        $datosoc = PurchaseOrder::query()
            ->where('authorization_4', 'Autorizado')
            ->get();

        return view('comprasdir.autorizadodir', compact('datosoc'));
    }

    public function indexrechazadodir()
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin','Contamex'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }


        $datosoc = PurchaseOrder::query()
            ->where('authorization_4', 'Rechazado')
            ->get();

        return view('comprasdir.rechazadodir', compact('datosoc'));
    }


    //TERMINAN AUTORIZACIONES DE LA DIRECTORA GENERAL 

    //EMPIEZA EDIT DE LA DIRECTORA GENERAL PARA AUTORIZAR
    public function editdirectora($id, $requisicione) //ESTE ALIMENTA AL COMPONENTE
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras', 'Diradmin',])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

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
        return view('comprasdir.editdir', compact('order', 'today', 'proveedor', 'producto', 'item', 'days_remaining_now', 'initialData'));
    }

    //FIN EDIT DE LA DIRECTORA GENERAL


    //MIS OC - VISTA PARA LOS CLIENTES EN GENERAL Y PUEDAN VER SUS RESPECTIVAS OC 

    public function misordenes()
    {


        // Si el usuario no tiene ciertos roles, filtrar por user_id
        if (!auth()->user()->hasRole([''])) {
            $orderclient = PurchaseOrder::query()
                ->WhereHas('requisition.user', function ($query) {
                    $query->where('id', auth()->id());
                })
                ->orderBy('id', 'desc')
                ->get();

            // Obtener las requisiciones con los filtros aplicados

            return view('compras.misordenes', compact('orderclient'));
        }
    }
}
