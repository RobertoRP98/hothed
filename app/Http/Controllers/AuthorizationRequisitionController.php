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

    public function indexclient(){

        $query = Requisition::query();

           // Si el usuario no tiene ciertos roles, filtrar por user_id
    if (!auth()->user()->hasRole([''])) {
        $query->where('user_id', auth()->id());
    }

    // Obtener las requisiciones con los filtros aplicados
    $requisitionclient = $query->get();

        return view('requisitionauth.viewclient', compact('requisitionclient'));
    }


}