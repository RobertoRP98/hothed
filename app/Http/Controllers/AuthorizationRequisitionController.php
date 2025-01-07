<?php

namespace App\Http\Controllers;

use App\Models\Requisition;

class AuthorizationRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexadm()
    {

        // Verificar explícitamente que el usuario tiene el rol correcto
    if (!auth()->user()->hasRole(['Developer', 'Adm', 'Cobranza'])) {
        abort(403, 'No tienes permiso para acceder a esta vista.');
    } 
        $requisitionadm = Requisition::whereHas('user', function ($query) {
            $query->where('departament', 'ADM');
        })->get();

        return view ('requisitionauth.viewadm', compact('requisitionadm'));
    }

    public function indexope()
    {

                // Verificar explícitamente que el usuario tiene el rol correcto
    if (!auth()->user()->hasRole(['Developer', 'Ope', 'Cobranza'])) {
        abort(403, 'No tienes permiso para acceder a esta vista.');
    }


        $requisitionope = Requisition::whereHas('user', function ($query){
            $query->where('departament','OP');
        })->get();

        return view ('requisitionauth.viewope', compact('requisitionope'));

    
}
}