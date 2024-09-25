<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ToolHistory;
use App\Http\Requests\StoreToolHistoryRequest;
use App\Http\Requests\UpdateToolHistoryRequest;
use App\Models\Toolwarehouse;
use Illuminate\Http\Client\Request;


class ToolHistoryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $histories = ToolHistory::with('toolwarehouse','user')->orderBy('created_at','desc')->get();
     return view('toolwarehouse.index', compact('tools','histories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ToolHistory $toolHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ToolHistory $toolHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolHistoryRequest $request, $id)
    {
        $toolwarehouse = Toolwarehouse::findOrFail($id);

        //recorre cada campo modificado y lo preparada para ser guardado
        foreach($request->all() as $key => $value){
            if($toolwarehouse->getOriginal($key) != $value) { // si el valor ha cambiado
                ToolHistory::create([
                    'toolwarehouse_id' => $toolwarehouse->id,
                    'user_id' => auth()->User()->id,
                    'field' => $key,
                    'old_value' => $toolwarehouse->$key,
                    'new_value' => $value,
                    
                ]);
            }
        }

        $toolwarehouse->update($request->all());

        return redirect()->route('toolwarehouse.show', $toolwarehouse->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ToolHistory $toolHistory)
    {
        //
    }
}
