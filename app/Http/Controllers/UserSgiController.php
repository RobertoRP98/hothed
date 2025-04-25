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
        $datos['users'] = UserSgi::all();

        return view('user-sgi.index',compact($datos));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = AreaSgi::all();
        $workstations = Workstation::all();

        return view('users-sgi.create', compact(['areas','workstations']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserSgiRequest $request)
    {
        $datosuser = $request->validated();

        UserSgi::create($datosuser);

        return redirect('users-sgi')->with('message','Usuario Creado');
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
        $datosuser = UserSgi::findOrFail($id);

        $areas = AreaSgi::all();

        $workstations = Workstation::all();

        return view ('users-sgi.edit',compact('datosuser','areas','workstations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserSgiRequest $request, $id)
    {
        $datosuser = $request->validated();

        UserSgi::where('id',$id)->update($datosuser);

        return redirect('users-sgi')->with('message','Usuario Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSgi $userSgi)
    {
        //
    }
}
