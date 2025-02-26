<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Base;
use App\Models\User;
use App\Models\Family;
use App\Models\Subgroup;
use App\Models\Toolstatus;
use App\Models\ToolHistory;
use App\Models\Toolwarehouse;
use App\Exports\ToolwarehouseExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreToolwarehouseRequest;
use App\Http\Requests\UpdateToolwarehouseRequest;




class ToolwarehouseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toolwarehouse = Toolwarehouse::with(['toolstatus:id,status', 
        'subgroup:id,name', 
        'family:id,name', 
        'base:id,name'])
            ->get();

        $toolstatus = Toolstatus::all();
        $subgroups = Subgroup::all();
        $families = Family::all();
        $bases = Base::all();

        return view('toolwarehouse.index', compact('toolwarehouse', 'toolstatus', 'subgroups', 'families', 'bases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $families = Family::select('id', 'name')->get();
        $subgroups = Subgroup::select('id', 'name')->get();
        $bases = Base::select('id', 'name')->get();
        $toolstatus = Toolstatus::select('id', 'status')->get();
        return view('toolwarehouse.create', compact('families', 'subgroups', 'bases', 'toolstatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolwarehouseRequest $request)
    {
        $field = [
            'family_id' => 'required',
            'subgroup_id' => 'required',
            'description' => 'required',
            'serienum' => 'required',
            'extdia' => 'required',
            'length' => 'required',
            'toolstatus_id' => 'required',
            'base_id' => 'required'
        ];
        $message = ['required' => 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datostoolwarehouse = $request->except('_token');
        Toolwarehouse::insert($datostoolwarehouse);

        return redirect('almacen-herramientas')->with('message', 'Herramienta agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $toolwarehouse = Toolwarehouse::with('histories.user')->findOrFail($id);
        $families = Family::select('id', 'name')->get();
        $subgroups = Subgroup::select('id', 'name')->get();
        $bases = Base::select('id', 'name')->get();
        $toolstatus = Toolstatus::select('id', 'status')->get();
        return view('toolwarehouse.show', compact('toolwarehouse', 'families', 'subgroups', 'bases', 'toolstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $toolwarehouse = Toolwarehouse::FindOrFail($id);
        $families = Family::select('id', 'name')->get();
        $subgroups = Subgroup::select('id', 'name')->get();
        $bases = Base::select('id', 'name')->get();
        $toolstatus = Toolstatus::select('id', 'status')->get();
        return view('toolwarehouse.edit', compact('toolwarehouse', 'families', 'subgroups', 'bases', 'toolstatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolwarehouseRequest $request, $id)
    {
        // Validar los campos
        $field = [
            'family_id' => 'required',
            'subgroup_id' => 'required',
            'description' => 'required',
            'serienum' => 'required',
            'extdia' => 'required',
            'length' => 'required',
            'toolstatus_id' => 'required',
            'base_id' => 'required'
        ];
        $message = ['required' => 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        // Obtener los datos de la herramienta actual (antes de la actualización)
        $toolwarehouse = Toolwarehouse::with(['family', 'subgroup', 'toolstatus', 'base'])->findOrFail($id);

        // Obtener los datos del request excluyendo _token y _method
        $datostoolwarehouse = $request->except(['_token', '_method']);

        // Inicializar el array de historiales
        $histories = [];

        // Array de traducción de campos a nombres legibles
        $fieldTranslations = [
            'family_id' => 'Familia',
            'subgroup_id' => 'Subgrupo',
            'toolstatus_id' => 'Estado de Herramienta',
            'base_id' => 'Base',
        ];

        // Luego, en el código del historial:
        foreach ($datostoolwarehouse as $key => $value) {
            // Si hay un cambio
            if ($toolwarehouse->getOriginal($key) != $value) {
                // Verificar si el campo es una relación
                if (array_key_exists($key, $fieldTranslations)) {
                    // Obtener los valores legibles para los campos de relación
                    $oldValue = optional($this->getRelationModel($key, $toolwarehouse->getOriginal($key)))->name ?? '';
                    $newValue = optional($this->getRelationModel($key, $value))->name ?? '';

                    // Cambiar el nombre del campo a su versión traducida
                    $key = ucfirst($fieldTranslations[$key]);

                    // Evitar guardar campos ID si ya están representados por su nombre traducido
                    if ($key !== 'family_id') {
                        $histories[] = [
                            'toolwarehouse_id' => $toolwarehouse->id,
                            'user_id' => auth()->user()->id,
                            'field' => $key,
                            'old_value' => $oldValue,
                            'new_value' => $newValue,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                } else {
                    // Para campos normales (no relaciones)
                    $oldValue = $toolwarehouse->getOriginal($key);
                    $newValue = $value;

                    // Si es un campo de fecha, formatearlo
                    if ($key == 'departuredate' || $key == 'Fecha de salida') {
                        $oldValue = Carbon::parse($oldValue)->format('d/m/Y');
                        $newValue = Carbon::parse($newValue)->format('d/m/Y');
                    }

                    $histories[] = [
                        'toolwarehouse_id' => $toolwarehouse->id,
                        'user_id' => auth()->user()->id,
                        'field' => ucfirst($key),
                        'old_value' => $oldValue,
                        'new_value' => $newValue,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insertar el historial si hay cambios
        if (!empty($histories)) {
            ToolHistory::insert($histories); // Esta línea debe eliminarse
        }

        // Actualizar los datos de la herramienta
        $toolwarehouse->update($datostoolwarehouse);

        // Redirigir con un mensaje de éxito
        return redirect('almacen-herramientas')->with('message', 'Herramienta actualizada y cambios registrados');
    }


    /**
     * Obtener el modelo relacionado basado en el campo clave.
     * 
     * @param string $key El nombre del campo (como family_id)
     * @param int $id El ID del campo
     * @return Model|null El modelo relacionado o null si no existe
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toolwarehouse $toolwarehouse)
    {
        //
    }

    public function history()
    {
     $histories = ToolHistory::with(['user:id,name','toolwarehouse:id,description,serienum'])
     ->orderBy('created_at', 'desc')
     ->get();

     $user=User::select('id','name')->get();
     $toolwarehouse=Toolwarehouse::select('id','description','serienum')->get();
     return view('toolwarehouse.history', compact('histories', 'user','toolwarehouse'));
    }
    


    public function exportReporteHerramientas()
    {
        return Excel::download(new ToolwarehouseExport, 'HERRAMIENTAS HHM AL ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }
  
}
