@extends('layouts.app')
@section('indexclient')

<div class="container">
 @if(Session::has('message'))
 {{Session::get('message')}}
 @endif   

 @push('css')
   <!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
@endpush


 <div class="container">
   <br>
   <button type="button" class="btn btn-outline-success mb-3 mt-3 m-2"> <a class="text-dark text-decoration-none" href="{{ route('facturas.index') }}">
      Regresar
  </a> </button> 
    <h2>Contratos de Pemex Pendiente de Cobrar NO Vencidas</h2>
    <br>

    <div class="card">
        <div class="card-body">
            
    <div class="table-responsive">
    <table id="pempcnv" class="table table-light table-bordered table-hover">    
      <thead class="thead-light">
              <tr>
                  <th>CLIENTE</th>
                  <th>NO.FACTURA</th>
                  <th>FECHA FACTURA</th>
                  <th>FECHA DE ENTRADA</th>
                  <th>FECHA DE EXPIRACIÓN</th>
                  <th>DIAS ANTES DE VENCER</th>
                  <th>TOTAL</th>
              </tr>
          </thead>
          <tbody>
              @foreach($facturaspubnov as $novencidapub)
              <tr>
                  <td>{{$novencidapub->companyreceivable->name}}</td>
                  <td>{{$novencidapub->bill_number}}</td>
                  <td>{{$novencidapub->bill_date}}</td>
                  <td>{{$novencidapub->entry_date}}</td>
                  <td>{{$novencidapub->expiration_date}}</td>
                  <td class="table-success {{$novencidapub->diasExpirados < 0 ? 'green' : 'black'}}">{{floor($novencidapub->diasExpirados)}}</td>
                  <td>{{$novencidapub->total_payment}}</td>            
              </tr>
              @endforeach
          </tbody>
      </table>
      </div>
    </div>
</div>
 </div>
</div>
@endsection


@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        $('#pempcnv').DataTable({
            resposive:true,
            autoWidth: false,

            "language": {
                "lengthMenu":     "Mostrar _MENU_ registros",
    "loadingRecords": "Cargando...",
    "processing":     "",
    "info": "Mostrando la página _PAGE_ de _PAGES_",
    "search":         "Buscar:",
    "zeroRecords":    "Registro no encontrado - Verifica el texto, elimina espacios al inicio y al final",
    "paginate": {
        "first":      "Inicio",
        "last":       "Ultimo",
        "next":       "Siguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "orderable":  "Ordenado por esta columna",
        "orderableReverse": "Columna ordenada inversamente"
    }
            }
        }); // Asegúrate de que el ID coincida con tu tabla
    });
</script>
@endpush