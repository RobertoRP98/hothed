<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Family;
use App\Models\Subgroup;
use App\Models\Toolstatus;
use App\Models\ToolHistory;
use Illuminate\Http\Request;
use App\Models\Toolwarehouse;
use App\Http\Requests\StoreToolwarehouseRequest;
use App\Http\Requests\UpdateTool_historyRequest;
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
        $toolwarehouse = Toolwarehouse::with(['toolstatus:id,status','subgroup:id,name','family:id,name','base:id,name'])
            ->paginate(30);
    
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
        $families=Family::select('id','name')->get();
        $subgroups=Subgroup::select('id','name')->get();
        $bases=Base::select('id','name')->get();
        $toolstatus=Toolstatus::select('id','status')->get();
        return view('toolwarehouse.create', compact('families','subgroups','bases','toolstatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolwarehouseRequest $request)
    {
        $field=['family_id'=>'required', 
                'subgroup_id'=>'required', 
                'description'=>'required', 
                'serienum'=>'required', 
                'extdia'=>'required', 
                'length'=>'required', 
                'toolstatus_id'=>'required',
                'base_id' =>'required'];
        $message=['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);

        $datostoolwarehouse=$request->except('_token');
        Toolwarehouse::insert($datostoolwarehouse);

        return redirect('almacenherramientas')->with('message','Herramienta agregada');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $toolwarehouse=Toolwarehouse::with('histories.user')->findOrFail($id);
        $families=Family::select('id','name')->get();
        $subgroups=Subgroup::select('id','name')->get();
        $bases=Base::select('id','name')->get();
        $toolstatus=Toolstatus::select('id','status')->get();
        return view('toolwarehouse.show', compact('toolwarehouse', 'families', 'subgroups','bases', 'toolstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $toolwarehouse=Toolwarehouse::FindOrFail($id);
        $families=Family::select('id','name')->get();
        $subgroups=Subgroup::select('id','name')->get();
        $bases=Base::select('id','name')->get();
        $toolstatus=Toolstatus::select('id','status')->get();
        return view('toolwarehouse.edit', compact('toolwarehouse', 'families', 'subgroups','bases', 'toolstatus'));
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
        $message = ['required'=> 'El :attribute es requerido'];
        $this->validate($request, $field, $message);
    
        // Obtener datos del request excluyendo _token y _method
        $datostoolwarehouse = $request->except(['_token', '_method']);
    
        // Obtener el registro antes de actualizar
        $toolwarehouse = Toolwarehouse::findOrFail($id);
    
        // Guardar los cambios en la herramienta primero
        $toolwarehouse->update($datostoolwarehouse);
    
        // Crear historial solo para los campos que han cambiado
        $histories = []; 
        foreach ($datostoolwarehouse as $key => $value) {
            // Verificar si el valor ha cambiado
            if ($toolwarehouse->getOriginal($key) != $value) {
                // Si el valor cambió, añadirlo al historial
                $histories[] = [
                    'toolwarehouse_id' => $toolwarehouse->id,
                    'user_id' => auth()->user()->id, // Usuario autenticado
                    'field' => $key,
                    'old_value' => $toolwarehouse->getOriginal($key),
                    'new_value' => $value,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
    
        // Insertar los registros de historial si hay cambios
        if (!empty($histories)) {
            ToolHistory::insert($histories);
        }
    
        // Redirigir con mensaje de éxito
        return redirect('almacenherramientas')->with('message', 'Herramienta actualizada y cambios registrados');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toolwarehouse $toolwarehouse)
    {
        //
    }

    public function search(Request $request)
    {
        $search = $request->input('keyword'); // Recibe el término de búsqueda
    
        // Asegúrate de paginar también los resultados de búsqueda
        $tools = Toolwarehouse::query()
            ->where('serienum', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%") // Si quieres buscar en más campos
            ->with(['toolstatus', 'family', 'base'])
            ->paginate(50);
    
        return response()->json($tools);
    }
    

    public function list(Request $request)
    {
        $search = $request->input('keyword'); // Recibe el término de búsqueda
    
        // Filtra y pagina los resultados de búsqueda
        $tools = Toolwarehouse::query()
            ->where('serienum', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->with(['toolstatus', 'family', 'base'])
            ->paginate(50); // Asegúrate de paginar correctamente
    
        return response()->json($tools);
    }

}
