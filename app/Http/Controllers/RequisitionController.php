<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Requisition;
use App\Http\Requests\StoreRequisitionRequest;
use App\Http\Requests\UpdateRequisitionRequest;
use App\Models\ItemRequisition;
use Carbon\Carbon;
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

        $today = Carbon::now()->format('Y-m-d');
        $initialData = [
            'formData' => [
                'user_id' => auth()->id(),
                'status_requisition' => 'Pendiente',
                'importance' => 'Baja',
                'finished' => '0',
                'production_date' => $today,
                'request_date' => $today,
                'days_remaining' => 0,
            ],
            'productData' => [], // Inicialmente vacío
        ];
        $productos = Product::all();


        return view('requisition.create', compact('productos', 'today','initialData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequisitionRequest $request)
    {
        Log::info('Entrando al método store', ['request_data' => $request->all()]);
        dd($request->all()); // Inspecciona el contenido recibido
        
        DB::transaction(function () use ($request) {
            // Crear la requisición principal
            $requisition = Requisition::create($request->only([
                'user_id',
                'status_requisition',
                'importance',
                'finished',
                'production_date',
                'request_date',
                'days_remaining'
            ]));
    
            // Crear los ítems relacionados
            foreach ($request->input('items_requisition') as $item) {
                ItemRequisition::create([
                    'requisition_id' => $requisition->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });
    
        return redirect('requisiciones')->with('message', 'Requisición Agregada');
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
