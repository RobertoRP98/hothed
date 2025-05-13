<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserSgiRequest;
use App\Http\Requests\UpdateUserSgiRequest;
use App\Models\AreaSgi;
use App\Models\UserSgi;
use App\Models\Workstation;

class UserSgiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserSgi::all();

        return view('modulo-documentos.users-sgi.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = AreaSgi::all();
        $workstations = Workstation::all();
        $users = UserSgi::all();

        return view('modulo-documentos.users-sgi.create', compact(['areas', 'workstations', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserSgiRequest $request)
    {
        $datosuser = $request->validated();

        // Forzar los campos vacíos a null
        foreach (['workstation_id', 'immediate_boss_id', 'area_id'] as $campo) {
            if (empty($datos[$campo])) {
                $datos[$campo] = null;
            }
        }

        UserSgi::create($datosuser);

        return redirect('users-sgi')->with('message', 'Usuario Creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserSgi $userSgi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = UserSgi::findOrFail($id);

        $users = UserSgi::all();

        $areas = AreaSgi::all();

        $workstations = Workstation::all();

        return view('modulo-documentos.users-sgi.edit', compact('users', 'areas', 'workstations', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserSgiRequest $request, $id)
    {
        $datosuser = $request->validated();

         // Forzar los campos vacíos a null
         foreach (['workstation_id', 'immediate_boss_id', 'area_id'] as $campo) {
            if (empty($datos[$campo])) {
                $datos[$campo] = null;
            }
        }

        UserSgi::where('id', $id)->update($datosuser);

        return redirect('users-sgi')->with('message', 'Usuario Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSgi $userSgi)
    {
        //
    }
}
