<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Requisition;
use App\Models\ItemRequisition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreRequisitionRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UpdateRequisitionRequest;


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
    
        Log::info('Items recibidos:', $request->input('items_requisition'));


        try {

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
                $requisition = Requisition::create($request->only([
                    'user_id',
                    'status_requisition',
                    'importance',
                    'finished',
                    'production_date',
                    'request_date',
                    'days_remaining'
                ]));
        
                foreach ($request->input('items_requisition') as $item) {
                    ItemRequisition::create([
                        'requisition_id' => $requisition->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            });
        
            return response()->json(['message' => 'Requisición Agregada']);
        } catch (\Exception $e) {
            Log::error('Error al guardar la requisición: ' . $e->getMessage());
            return response()->json(['message' => 'Error al guardar la requisición'], 500);
        }
        
        // Enviar el mensaje en la respuesta JSON
    return response()->json(['message' => 'Requisición Agregada']);    
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
