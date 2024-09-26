<?php

namespace App\Http\Controllers;
use App\Models\ToolHistory;
use App\Http\Requests\StoreToolHistoryRequest;
use App\Http\Requests\UpdateToolHistoryRequest;
use App\Models\Toolwarehouse;
use App\Models\User;

class ToolHistoryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $histories = ToolHistory::with(['user:id,name','toolwarehouse:id,description'])->paginate(30);
     $user=User::select('id','name')->get();
     $toolwarehouse=Toolwarehouse::select('id','description')->get();
     return view('toolhistory.index', compact('histories', 'user','toolwarehouse'));
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
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ToolHistory $toolHistory)
    {
        //
    }
}
