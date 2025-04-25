<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAreaSgiRequest;
use App\Http\Requests\UpdateAreaSgiRequest;
use App\Models\AreaSgi;

class AreaSgiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = AreaSgi::paginate(30);

        return view('areas-sgi.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('areas-sgi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaSgiRequest $request)
    {
        $datosarea = $request->validated();

        AreaSgi::create($datosarea);

        return redirect ('areas-sgi')->with('message','Area de trabajo creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaSgi $areaSgi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $areas = AreaSgi::FindOrFail($id);

        return view('areas-sgi.edit', compact('areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaSgiRequest $request, $id)
    {
        $datosarea = $request->validated();

        AreaSgi::where('id', $id)->update($datosarea);

        return redirect('areas-sgi')->with('message','Area de trabajo actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaSgi $areaSgi)
    {
        //
    }
}
