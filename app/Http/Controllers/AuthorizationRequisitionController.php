<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Requisition;

class AuthorizationRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //INICIA INDICES DE CONTABILIDAD POR APROBAR
    public function indexcoordconta()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordconta'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionconta = Requisition::where('status_requisition', 'Pendiente')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE CONTABILIDAD');
            })
            ->get();
        return view('requisitionauth.contabilidad.viewindexconta', compact('requisitionconta'));
    }

    public function autconta()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordconta'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionconta = Requisition::where('status_requisition', 'Autorizado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE CONTABILIDAD');
            })
            ->get();
        return view('requisitionauth.contabilidad.viewautconta', compact('requisitionconta'));
    }

    public function canconta()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordconta'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionconta = Requisition::where('status_requisition', 'Rechazado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE CONTABILIDAD');
            })
            ->get();
        return view('requisitionauth.contabilidad.viewcanconta', compact('requisitionconta'));
    }

    public function finconta()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordconta'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionconta = Requisition::whereIn('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])
            ->where('finished', true)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE CONTABILIDAD');
            })
            ->get();
        return view('requisitionauth.contabilidad.viewfinconta', compact('requisitionconta'));
    }
    //FINALIZA INDICES DE CONTABILIDAD

    //INICIA INDICES DE ALMACEN POR APROBAR
    public function indexalm()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordalm'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionalm = Requisition::where('status_requisition', 'Pendiente')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE ALMACEN');
            })
            ->get();
        return view('requisitionauth.almacen.viewindexalm', compact('requisitionalm'));
    }

    public function autalm()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordalm'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionalm = Requisition::where('status_requisition', 'Autorizado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE ALMACEN');
            })
            ->get();
        return view('requisitionauth.almacen.viewautalm', compact('requisitionalm'));
    }

    public function canalm()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordalm'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionalm = Requisition::where('status_requisition', 'Rechazado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE ALMACEN');
            })
            ->get();
        return view('requisitionauth.almacen.viewcanalm', compact('requisitionalm'));
    }

    public function finalm()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Coordalm'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionalm = Requisition::whereIn('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])
            ->where('finished', true)
            ->whereHas('user', function ($query) {
                $query->where('subarea', 'AUXILIAR DE ALMACEN');
            })
            ->get();
        return view('requisitionauth.almacen.viewfinalm', compact('requisitionalm'));
    }
    //FINALIZA INDICES DE ALMACEN

    //INICIA INDICES DE SUBOPERACIONES
    public function indexsubope()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Subgerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionsubope = Requisition::where('status_requisition', 'Pendiente')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->whereIn('subarea', [
                    'AUXILIAR DE VENTAS Y OP',
                    'COORD. DE ALMACEN', 
                    'AUX DE LOGISTICA Y MANTO', 
                ]);
            })
            ->get();
        return view('requisitionauth.subope.viewindexsubope', compact('requisitionsubope'));
    }

    public function autsubope()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Subgerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionsubope = Requisition::where('status_requisition', 'Autorizado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->whereIn('subarea', [
                    'AUXILIAR DE VENTAS Y OP',
                    'COORD. DE ALMACEN', 
                    'AUX DE LOGISTICA Y MANTO', 
                ]);
            })
            ->get();
        return view('requisitionauth.subope.viewautsubope', compact('requisitionsubope'));
    }

    public function cansubope()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Subgerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionsubope = Requisition::where('status_requisition', 'Rechazado')
            ->where('finished', false)
            ->whereHas('user', function ($query) {
                $query->whereIn('subarea', [
                    'AUXILIAR DE VENTAS Y OP',
                    'COORD. DE ALMACEN', 
                    'AUX DE LOGISTICA Y MANTO', 
                ]);
            })
            ->get();
        return view('requisitionauth.subope.viewcansubope', compact('requisitionsubope'));
    }

    public function finsubope()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'Subgerope'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionsubope = Requisition::whereIn('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])
            ->where('finished', true)
            ->whereHas('user', function ($query) {
                $query->whereIn('subarea', [
                    'AUXILIAR DE VENTAS Y OP',
                    'COORD. DE ALMACEN', 
                    'AUX DE LOGISTICA Y MANTO', 
                ]);
            })
            ->get();
        return view('requisitionauth.subope.viewfinsubope', compact('requisitionsubope'));
    }
    //FINALIZA INDICES DE SUBOPERACIONES

     //INICIA INDICES DE SGI POR APROBAR
     public function indexsgi()
     {
         // Verificar explícitamente que el usuario tiene el rol correcto
         if (!auth()->user()->hasRole(['Developer', 'Respsgi'])) {
             abort(403, 'No tienes permiso para acceder a esta vista.');
         }
         $requisitionsgi = Requisition::where('status_requisition', 'Pendiente')
             ->where('finished', false)
             ->whereHas('user', function ($query) {
                 $query->where('subarea', 'COORD. DE HSE');
             })
             ->get();
         return view('requisitionauth.sgi.viewindexsgi', compact('requisitionsgi'));
     }
 
     public function autsgi()
     {
         // Verificar explícitamente que el usuario tiene el rol correcto
         if (!auth()->user()->hasRole(['Developer', 'Respsgi'])) {
             abort(403, 'No tienes permiso para acceder a esta vista.');
         }
         $requisitionsgi = Requisition::where('status_requisition', 'Autorizado')
             ->where('finished', false)
             ->whereHas('user', function ($query) {
                 $query->where('subarea', 'COORD. DE HSE');
             })
             ->get();
         return view('requisitionauth.sgi.viewautsgi', compact('requisitionsgi'));
     }
 
     public function cansgi()
     {
         // Verificar explícitamente que el usuario tiene el rol correcto
         if (!auth()->user()->hasRole(['Developer', 'Respsgi'])) {
             abort(403, 'No tienes permiso para acceder a esta vista.');
         }
         $requisitionsgi = Requisition::where('status_requisition', 'Rechazado')
             ->where('finished', false)
             ->whereHas('user', function ($query) {
                 $query->where('subarea', 'COORD. DE HSE');
             })
             ->get();
         return view('requisitionauth.sgi.viewcansgi', compact('requisitionsgi'));
     }
 
     public function finsgi()
     {
         // Verificar explícitamente que el usuario tiene el rol correcto
         if (!auth()->user()->hasRole(['Developer', 'Respsgi'])) {
             abort(403, 'No tienes permiso para acceder a esta vista.');
         }
         $requisitionsgi = Requisition::whereIn('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])
             ->where('finished', true)
             ->whereHas('user', function ($query) {
                 $query->where('subarea', 'COORD. DE HSE');
             })
             ->get();
         return view('requisitionauth.sgi.viewfinsgi', compact('requisitionsgi'));
     }
     //FINALIZA INDICES DE SGI





    // HASTA ABAJO HAY CONTROLLER DEL RESPONSABLE /////////////////////////////////////

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
                $query->whereIn('departament', ['OP', 'ADM']);
            })
            ->get();
        return view('requisitionauth.viewrespaut', compact('requisitionresp'));
    }

    public function indexrespcan()
    {
        // Verificar explícitamente que el usuario tiene el rol correcto
        if (!auth()->user()->hasRole(['Developer', 'RespCompras'])) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }
        $requisitionresp = Requisition::where('status_requisition', 'Rechazado')
            ->whereIn('finished', [false, true])
            ->whereHas('user', function ($query) {
                $query->whereIn('departament', ['OP', 'ADM']);
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
                $query->whereIn('departament', ['OP', 'ADM']);
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
            'internal_id',
            'description',
            'brand',
            'udm',
            'category'
        )->get();

        return view('product.indexclient', $datos);
    }
}
