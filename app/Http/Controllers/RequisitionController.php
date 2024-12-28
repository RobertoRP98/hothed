<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Requisition;
use App\Http\Requests\StoreRequisitionRequest;
use App\Http\Requests\UpdateRequisitionRequest;
use App\Models\ItemRequisition;
use Illuminate\Support\Facades\DB;


class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $datos['requisiciones'] = Requisition::all();

        return view('requisition.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Product::all();

        return view('requisition.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequisitionRequest $request)
    {
        DB::transaction(function () use ($request) {
            //Crear la requisicion principal
            $requisition = Requisition::create([
                'user_id' => auth()->user->id(),
                'status_requisition' => $request->status_requisition,
                'importance' => $request->importance,
                'finished' => $request->finished,
                'production_date' => $request->production_date,
                'request_date' => $request->request_date,
                'days_remaining' => $request->days_remaining,
            ]);

            foreach ($request->input('items_requisition') as $item) {
                ItemRequisition::create([
                    'requisition_id' => $requisition->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });
        return redirect('requisiciones')->with('message', 'Requisicion Agregada');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //mostrar la requisicion
        $requisition = Requisition::find($id);
        return view('requisition.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requisition $requisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequisitionRequest $request, Requisition $requisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requisition $requisition)
    {
        //
    }
}
