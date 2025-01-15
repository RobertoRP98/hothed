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

        $datos['requisiciones'] = Requisition::where('status_requisition', 'Pendiente')->get();

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
                'request_date' => $today,
                'production_date' => '',
                'days_remaining' => 0,
                'finished_date' => '',
            ],
            'productData' => [], // Inicialmente vacío
        ];

        $productos = Product::all();
        return view('requisition.create', compact('productos', 'today', 'initialData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequisitionRequest $request)
    {
        Log::info('Items recibidos:', $request->input('items_requisition'));

        try {
            $today = Carbon::now();
            $importanceDays = [
                'Baja' => 90,
                'Media' => 60,
                'Alta' => 30,
                'Critico' => 15,
            ];

            $importance = $request->input('importance', 'Baja');
            $daysToAdd = $importanceDays[$importance] ?? 90;
            $calculatedDate = $today->copy()->addDays($daysToAdd);

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

            DB::transaction(function () use ($request, $calculatedDate, $daysToAdd) {
                $today_production = Carbon::now()->format('Y-m-d');

                // Asignar valores calculados al almacenar la requisición
                $requisition = Requisition::create(array_merge(
                    $request->only([
                        'user_id',
                        'status_requisition',
                        'importance',
                        'finished',
                        'finished_date',
                    ]),
                    [
                        // Asignar fechas calculadas
                        'request_date' => $today_production, //DIA DONDE SE REALIZA LA REQUI 
                        'production_date' => $calculatedDate->format('Y-m-d'), //DIA MAXIMO DE DESPACHO
                        'days_remaining' => $daysToAdd,
                    ]
                ));

                // Guardar los ítems de la requisición
                foreach ($request->input('items_requisition') as $item) {
                    ItemRequisition::create([
                        'requisition_id' => $requisition->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            });



            $message = "Requisición creada con éxito";

            // Definir redirecciones por rol
            $roleRedirects = [
                'RespCompras' => '/requisiciones',
                'Developer' => '/requisiciones',
                'ClientCompras' => '/mis-requisiciones',
                'AdmCompras' => '/requisiciones-adm',
                'OpeCompras' => '/requisiciones-ope',
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

            // Respuesta por defecto si no tiene un rol esperado
            return response()->json([
                'message' => $message,
                'redirect' => '/',
            ]);
        } catch (ValidationException $e) {
            // Capturar errores de validación específicos
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar la requisición: ' . $e->getMessage());
            return response()->json(['message' => 'Error al guardar la requisición'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $query = Requisition::query();

        // Si el usuario no es Developer, filtrar por user_id
        if (!auth()->user()->hasRole(['Developer', 'OpeCompras', 'AdmCompras', 'RespCompras'])) {
            $query->where('user_id', auth()->id());
        }

        // Obtener la requisición o lanzar un 404 si no existe
        $requisition = $query->where('id', $id)->firstOrFail();


        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($requisition->production_date)->diffInDays(now(), false));


        // Calcular importancia
        if ($days_remaining_now >= -15) {
            $importance_now = 'CRITICO';
        } elseif ($days_remaining_now >= -30) {
            $importance_now = 'ALTA';
        } elseif ($days_remaining_now >= -60) {
            $importance_now = 'MEDIA';
        } else {
            $importance_now = 'BAJA';
        }

        $today = Carbon::now()->format('Y-m-d');

        $initialData = [
            'formData' => [
                'id' => $requisition->id,
                'user_id' => $requisition->user_id,
                'status_requisition' => $requisition->status_requisition,
                'importance' => $requisition->importance,
                'finished' => $requisition->finished,
                'request_date' => $requisition->request_date,
                'production_date' => $requisition->production_date,
                'days_remaining' => $requisition->days_remaining,
                'finished_date' => $requisition->finished_date,

                'importance_now' => $importance_now, // Agregar importancia calculada
                'days_remaining_now' => $days_remaining_now, // Agregar días restantes calculados

            ],
            'productData' => $requisition->itemsRequisition->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'description' => optional($item->product)->description ?? 'Producto no encontrado',
                    'quantity' => $item->quantity,
                    'suggestions' => [],
                ];
            })->toArray(),
        ];

        return view('requisition.show', compact('requisition', 'today', 'initialData'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $requisition = Requisition::with('itemsRequisition')->findOrFail($id);

        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($requisition->production_date)->diffInDays(now(), false));


        // Calcular importancia
        if ($days_remaining_now >= -15) {
            $importance_now = 'CRITICO';
        } elseif ($days_remaining_now >= -30) {
            $importance_now = 'ALTA';
        } elseif ($days_remaining_now >= -60) {
            $importance_now = 'MEDIA';
        } else {
            $importance_now = 'BAJA';
        }

        $today = Carbon::now()->format('Y-m-d');

        $initialData = [
            'formData' => [
                'id' => $requisition->id,
                'user_id' => $requisition->user_id,
                'status_requisition' => $requisition->status_requisition,
                'importance' => $requisition->importance,
                'finished' => $requisition->finished,
                'production_date' => $requisition->production_date,
                'request_date' => $requisition->request_date,
                'days_remaining' => $requisition->days_remaining,
                'finished_date' => $requisition->finished_date,

                'importance_now' => $importance_now, // Agregar importancia calculada
                'days_remaining_now' => $days_remaining_now, // Agregar días restantes calculados


            ],
            'productData' => $requisition->itemsRequisition->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'description' => optional($item->product)->description ?? 'Producto no encontrado',
                    'quantity' => $item->quantity,
                    'suggestions' => [],
                ];
            })->toArray(),
        ];

        return view('requisition.edit', compact(['initialData', 'requisition', 'today']));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequisitionRequest $request, Requisition $requisicione)
    {
        try {
            Log::info('Payload recibido:', $request->all());
            Log::info('Requisition ID:', ['id' => $requisicione->id]);

            $today = Carbon::now();
            $importanceDays = [
                'Baja' => 90,
                'Media' => 60,
                'Alta' => 30,
                'Critico' => 15,
            ];

            // Calcular nueva fecha de producción basada en la importancia
            $importance = $request->input('importance', 'Baja');
            $daysToAdd = $importanceDays[$importance] ?? 90;
            $calculatedDate = $today->copy()->addDays($daysToAdd);

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

            DB::transaction(function () use ($request, $requisicione, $calculatedDate, $daysToAdd) {
                // Actualizar los datos generales de la requisición
                $requisicione->update(array_merge(
                    $request->only([
                        'status_requisition',
                        'finished',
                    ]),
                    [
                        'importance' => $request->input('importance', 'Baja'),
                        'production_date' => $calculatedDate->format('Y-m-d'),
                        'days_remaining' => $daysToAdd,
                    ]
                ));

                // Depurar la lista antigua de productos para que entre la nueva
                $requisicione->itemsRequisition()->delete();

                // Guardar los ítems de la requisición
                foreach ($request->input('items_requisition') as $item) {
                    Log::info('Insertando item:', ['requisition_id' => $requisicione->id, 'item' => $item]);
                    $requisicione->itemsRequisition()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            });


            
            $message = "Requisición creada con éxito";

            // Definir redirecciones por rol
            $roleRedirects = [
                'RespCompras' => '/requisiciones',
                'Developer' => '/requisiciones',
                'ClientCompras' => '/mis-requisiciones',
                'AdmCompras' => '/requisiciones-adm',
                'OpeCompras' => '/requisiciones-ope',
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

            // Respuesta por defecto si no tiene un rol esperado
            return response()->json([
                'message' => $message,
                'redirect' => '/',
            ]);
        } catch (ValidationException $e) {
            // Capturar errores de validación específicos
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar la requisición: ' . $e->getMessage());
            return response()->json(['message' => 'Error al guardar la requisición'], 500);
        }

        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requisition $requisition)
    {
        //
    }
}
