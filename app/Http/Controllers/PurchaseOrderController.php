<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Requisition;
use App\Models\PurchaseOrder;
use App\Models\ItemOrderPurchase;
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

        //inicializacion de datos
        $initialData = [
            'formData'=>[
                'requisition_id' => $requisicion,
                'supplier_id' => 1,
                'type_op' => 'Local',
                'payment_type' => 'Transferencia',
                'unique_payment' => 0,
                'quotation' => '',
                'currency' => 'MXN',
                'date_start' => $today,
                'finished' => 0,
                'date_end' => '',
                'payment_day' => '',
                'status_requisition' => 'Autorizado',
                'authorization_2' => 'Pendiente',
                'authorization_3' => 'Pendiente',
                'authorization_4' => 'Pendiente',
                'delivery_condition' => '100% Antes Entrega',
                'po_status' => 'Pendiente de Pago',
                'bill' => 'Pendiente Facturar',
                'subtotal' => 0,
                'total_descuento'=> 0,
                'tax' => 0,
                'total' => 0,
            ],

            'supplierData' => [],
        ];

 

        return view('compras.create', compact('requisicion','proveedor','producto','item','initialData','today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        //
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
