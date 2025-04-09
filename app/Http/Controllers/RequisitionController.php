<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Requisition;
use App\Models\ItemRequisition;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Mail\RequisitionAuthorized;
use Illuminate\Support\Facades\Log;
use App\Mail\RequisitionCreatedMail;
use Illuminate\Support\Facades\Mail;
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

        $datos['requisiciones'] = Requisition::where('status_requisition', 'Autorizado')
            ->where('finished', false)
            ->get();

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
                //'petty_cash' => '0',
                'finished' => '0',

                'request_date' => $today, //fecha de solicitud
                'required_date' => '', //fecha requerida
                'production_date' => '', // fecha de entrega

                'days_remaining' => 0,

                'finished_date' => '',
                'notes_client' => '',
                'notes_resp' => '',
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
                'Alta' => 15,
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

            //  Inicializar fuera del transaction para poder usarla después
            $requisition = null;

            DB::transaction(function () use ($request, $calculatedDate, $daysToAdd, &$requisition) {
                $today_production = Carbon::now()->format('Y-m-d');

                // Asignar valores calculados al almacenar la requisición
                $requisition = Requisition::create(array_merge(
                    $request->only([
                        'user_id',
                        'status_requisition',
                        'importance',
                        'finished',
                        'finished_date',
                        'required_date',
                        'notes_client',
                        'notes_resp'
                    ]),
                    [
                        'request_date' => $today_production, // Día en que se hace la requisición
                        'production_date' => $calculatedDate->format('Y-m-d'), // Día máximo de despacho
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

            //  Si la requisición se creó con éxito, enviar el correo
            if ($requisition) {
                $subarea = $requisition->user->subarea;
                $emails = [
                    'AUXILIAR DE CONTABILIDAD' => 'noemi.hernandez@hothedmex.mx', //NOEMI
                    'AUXILIAR DE ALMACEN', //RESP DE ALMACEN
                    'AUXILIAR DE VENTAS Y OP' => 'david.hernandez@hothedmex.mx', //DAVID
                    'AUX DE LOGISTICA Y MANTO'=> 'david.hernandez@hothedmex.mx',
                    'ESP. TECNICO' => 'david.hernandez@hothedmex.mx', // FIN DAVID
                    'COORD. DE HSE' => 'laura.delariva@hothedmex.mx', //LAURA
                    'GER. OPE' => 'karla.ibeth.segura@hothedmex.mx', //DIR KARLA
                    'COORD. CONTABILIDAD' => 'karla.ibeth.segura@hothedmex.mx',
                    'RESP. DE SGI'=> 'karla.ibeth.segura@hothedmex.mx',
                    'COORD. CONTRATOS' => 'karla.ibeth.segura@hothedmex.mx',
                    'DIR. OPERACIONES'=> 'karla.ibeth.segura@hothedmex.mx',
                    'COORD. DE RECURSOS HUMANOS' => 'karla.ibeth.segura@hothedmex.mx',
                    'RESP. DE COMPRAS' => 'karla.ibeth.segura@hothedmex.mx', //FIN DIR KARLA
                    'COORD. DE VENTAS' => 'alejandro.flores@hothedmex.mx', //FLORES
                    'SUB. GER. OPE' => 'alejandro.flores@hothedmex.mx',
                    'COORD. DE ALMACEN' => 'alejandro.flores@hothedmex.mx', //FIN FLORES
                    'AUX. CONTRATOS' => 'miriam.hernandez@hothedmex.mx',// MIRIAM
                    'MCFLY' => 'ale.santos@hothedmex.mx',//SANTOS
                    'AUXILIAR DE TI' => 'karla.ibeth.segura@hothedmex.mx',
                ];

                if (isset($emails[$subarea])) {
                    Mail::to($emails[$subarea])->send(new RequisitionCreatedMail($requisition));
                } else {
                    Log::warning("No se encontró correo para la subárea: " . $subarea);
                }
            }

            $message = "Requisición creada con éxito";

            // Definir redirecciones por rol
            $roleRedirects = [
                'Developer' => '/requisiciones',
                'RespCompras' => '/requisiciones',
                // Empleados solicitantes
                'Auxconta' => '/mis-requisiciones',
                'Mcfly' => '/mis-requisiciones',
                'Auxalmacen' => '/mis-requisiciones',
                'Auxopeventas' => '/mis-requisiciones',
                'Coordrh' => '/mis-requisiciones',
                'Auxcontratos' => '/mis-requisiciones',
                // Aprobadores - que algunos también son solicitantes
                'Coordconta' => '/requisiciones-contabilidad',
                'Coordalm' => '/requisiciones-almacen',
                'Subgerope' => '/requisiciones-subope',
                'Gerope' => '/requisiciones-gerope',
                'Respsgi' => '/requisiciones-sgi',
                'Diradmin' => '/requisiciones-administracion',
                'Dirope' => '/requisiciones-dirope',
                'Coordcontratos' => '/requisiciones-contratos',
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
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar la requisición: ' . $e->getMessage());
            Log::info('Valor de importance:', ['importance' => $request->input('importance')]);
            Log::info('Datos recibidos:', $request->all());

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
        // if (!auth()->user()->hasRole(['Developer'])) {
        //     $query->where('user_id', auth()->id());
        // }

        // Obtener la requisición o lanzar un 404 si no existe
        $requisition = $query->where('id', $id)->firstOrFail();


        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($requisition->production_date)->diffInDays(now(), false));


        // Calcular importancia
        if ($days_remaining_now >= -15) {
            $importance_now = 'ALTA';
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

                'required_date' => $requisition->required_date,
                // 'petty_cash' => $requisition->petty_cash,
                'notes_client' => $requisition->notes_client,
                'notes_resp' => $requisition->notes_resp,

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
            $importance_now = 'ALTA';
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

                'required_date' => $requisition->required_date,
                //'petty_cash' => $requisition->petty_cash,
                'notes_client' => $requisition->notes_client,
                'notes_resp' => $requisition->notes_resp,


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
                'Alta' => 15,
            ];
    
            $importance = $request->input('importance', 'Baja');
            $daysToAdd = $importanceDays[$importance] ?? 90;
            $calculatedDate = $today->copy()->addDays($daysToAdd);
    
            // Validar productos
            $productIds = array_column($request->input('items_requisition', []), 'product_id');
            $validProductIds = Product::whereIn('id', $productIds)->pluck('id')->toArray();
    
            foreach ($productIds as $id) {
                if (!in_array($id, $validProductIds)) {
                    throw ValidationException::withMessages([
                        'items_requisition' => 'Uno o más productos seleccionados no son válidos.',
                    ]);
                }
            }
    
            // Inicializamos fuera de la transacción para refrescar luego
            $requisition = $requisicione;
    
            DB::transaction(function () use ($request, $requisicione, $calculatedDate, $daysToAdd, $importance, &$requisition) {
    
                // Construimos el array de datos base
                $updateData = $request->only([
                    'status_requisition',
                    'finished',
                    'notes_client',
                    'notes_resp',
                    'finished_date'
                ]);
    
                // Solo actualizamos importance y fechas si cambió la importance
                if ($requisicione->importance !== $importance) {
                    $updateData['importance'] = $importance;
                    $updateData['production_date'] = $calculatedDate->format('Y-m-d');
                    $updateData['days_remaining'] = $daysToAdd;
                }
    
                $requisicione->update($updateData);
    
                // Reemplazar productos
                $requisicione->itemsRequisition()->delete();
    
                foreach ($request->input('items_requisition') as $item) {
                    Log::info('Insertando item:', ['requisition_id' => $requisicione->id, 'item' => $item]);
                    $requisicione->itemsRequisition()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            });

            // Recargar requisición actualizada
            $requisition->refresh();

            Log::info('Estado de requisición después del update:', [
                'requisition' => $requisition,
                'status' => $requisition ? $requisition->status_requisition : 'NULL'
            ]);


            //  Si la requisición se creó con éxito, enviar el correo
            if ($requisition->wasChanged('status_requisition') && $requisition->status_requisition == 'Autorizado') {


                $emails = [
                    'bianca.fernanda.rebolledo@hothedmex.mx',
                    //agrega mas correos si hay mas responsables de compras
                ];

                Log::info('Enviando correo a:', ['emails' => $emails]);
                Mail::to($emails)->send(new RequisitionAuthorized($requisition));
            }



            $message = "Requisición actualizada con éxito";

            // Definir redirecciones por rol
            $roleRedirects = [
                'Developer' => '/requisiciones',
                'RespCompras' => '/requisiciones',
                //Empleados solicitantes
                'Auxconta' => '/mis-requisiciones',
                'Auxalmacen' => '/mis-requisiciones',
                'Mcfly' => '/mis-requisiciones',
                'Auxopeventas' => '/mis-requisiciones',
                'Coordrh' => '/mis-requisiciones',
                'Auxcontratos' => '/mis-requisiciones',
                '' => '/mis-requisiciones',
                '' => '/mis-requisiciones',
                //Aprovadores - que algunos tambien son solicitantes
                // pero en la vista index se les agrega el boton mis requisiciones para que puedan ver sus requis 
                'Coordconta' => '/requisiciones-contabilidad',
                'Coordalm' => '/requisiciones-almacen',
                'Subgerope' => '/requisiciones-subope',
                'Gerope' => '/requisiciones-gerope',
                'Respsgi' => '/requisiciones-sgi',
                'Diradmin' => '/requisiciones-administracion',
                'Dirope' => '/requisiciones-dirope',
                'Coordcontratos' => '/requisiciones-contratos',

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

            // Verificar qué se está enviando al frontend
            Log::info('Redirigiendo a:', ['redirect' => $redirect]);

            // Respuesta por defecto si no tiene un rol esperado
            return response()->json([
                'message' => $message,
                'redirect' => '/',
            ]);
        } catch (ValidationException $e) {
            // Capturar errores de validación específicos
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la requisición: ' . $e->getMessage());
            return response()->json(['message' => 'Error al actualizar la requisición'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requisition $requisition)
    {
        //
    }


    public function pdf($id)
    {
        $query = Requisition::query();



        // Obtener la requisición o lanzar un 404 si no existe
        $requisition = $query->where('id', $id)->firstOrFail();


        // Calcular días restantes
        $days_remaining_now = floor(\Carbon\Carbon::parse($requisition->production_date)->diffInDays(now(), false));


        // Calcular importancia
        if ($days_remaining_now >= -15) {
            $importance_now = 'ALTA';
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

                'required_date' => $requisition->required_date,
                // 'petty_cash' => $requisition->petty_cash,
                'notes_client' => $requisition->notes_client,
                'notes_resp' => $requisition->notes_resp,

                'importance_now' => $importance_now, // Agregar importancia calculada
                'days_remaining_now' => $days_remaining_now, // Agregar días restantes calculados

                'dep_user' => $requisition->user->area

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

        $pdf = Pdf::loadview('requisition.pdf', compact('requisition', 'today', 'initialData'));
        return $pdf->download('Requisicion ' . $initialData['formData']['id'] . '.pdf');
    }
}
