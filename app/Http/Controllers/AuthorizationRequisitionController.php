<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Requisition;

class AuthorizationRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //INICIA INDICES DE ADMINISTRACION 
    //PENDIENTES DE AUTORIZACIÓN
    public function indexadm()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'AdmCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionadm = Requisition::where('status_requisition', 'Pendiente')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('departament', 'ADM');
            })
            ->get();
        return view('requisitionauth.viewadm', compact('requisitionadm'));
    }

    public function indexadmaut()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'AdmCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionadm = Requisition::where('status_requisition', 'Autorizado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('departament', 'ADM');
            })
            ->get();
        return view('requisitionauth.viewadmaut', compact('requisitionadm'));
    }

    public function indexadmcan()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'AdmCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionadm = Requisition::where('status_requisition', 'Rechazado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('departament', 'ADM');
            })
            ->get();
        return view('requisitionauth.viewadmcan', compact('requisitionadm'));
    }

    public function indexadmfin()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'AdmCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionadm = Requisition::whereIn('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])
            ->where('finished', true)
            ->whereHas('user', function ($query) {
                $query->where('departament', 'ADM');
            })
            ->get();
        return view('requisitionauth.viewadmfin', compact('requisitionadm'));
    }


    //FINALIZA INDICES DE ADMINISTRACIÓN

    //INICIA INDICES DE OPERACIONES

    public function indexope()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'OpeCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionope = Requisition::whereHas('user', function ($query) {
            $query->where('departament', 'OP');
        })->get();

        return view('requisitionauth.viewope', compact('requisitionope'));
    }

    public function indexopeaut()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'OpeCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionope = Requisition::where('status_requisition', 'Autorizado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('departament', 'OP');
            })
            ->get();
        return view('requisitionauth.viewopeaut', compact('requisitionope'));
    }

    public function indexopecan()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'OpeCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionope = Requisition::where('status_requisition', 'Rechazado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('departament', 'OP');
            })
            ->get();
        return view('requisitionauth.viewopecan', compact('requisitionope'));
    }

    public function indexopefin()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'OpeCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionope = Requisition::whereIn('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])
            ->where('finished', true)
            ->whereHas('user', function ($query) {
                $query->where('departament', 'OP');
            })
            ->get();
        return view('requisitionauth.viewopefin', compact('requisitionope'));
    }


    //FINALIZA INDICES DE OPERACIONES
    //INICIA INDICES DE RESPONSABLE 

    public function indexrespaut()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionresp = Requisition::where('status_requisition', 'Autorizado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->whereIn('departament', ['OP','ADM']);
            })
            ->get();
        return view('requisitionauth.viewrespaut', compact('requisitionresp'));
    }

    public function indexrespcan()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras' ])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionresp = Requisition::where('status_requisition', 'Rechazado')
            ->whereIn('finished', [false, true])
            ->whereHas('user', function ($query) {
                $query->whereIn('departament', ['OP','ADM']);
            })
            ->get();
        return view('requisitionauth.viewrespcan', compact('requisitionresp'));
    }

    public function indexrespfin()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionresp = Requisition::whereIn('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])
            ->where('finished', true)
            ->whereHas('user', function ($query) {
                $query->whereIn('departament', ['OP','ADM']);
            })
            ->get();
        return view('requisitionauth.viewrespfin', compact('requisitionresp'));
    }

    //FINALIZA INDICES DE RESPONSABLE

//INICIA INDICE DE CLIENTE - MIS REQUISICIONES

    public function indexclient()
    {

        $query = Requisition::query();

        // Si el usuario no tiene ciertos roles, filtrar por user_id
        if (!auth()->user()->hasRole([''])) {
            $query->where('user_id', auth()->id());
        }
        // Obtener las requisiciones con los filtros aplicados
        $requisitionclient = $query->get();

        return view('requisitionauth.viewclient', compact('requisitionclient'));
    }


    public function productclient()
    {
        $datos['products'] = Product::select(
            'internal_id', 'description', 'brand', 'udm', 'category')->get();

        return view('product.indexclient', $datos);
    }
}
