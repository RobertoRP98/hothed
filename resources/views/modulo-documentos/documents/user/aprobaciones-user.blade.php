@extends('layouts.app')
@section('indexsupplier')
    <div class="container">
        @if (Session::has('message'))
            {{ Session::get('message') }}
        @endif


        @if (request()->has('message'))
            <div class="alert alert-success">
                {{ request('message') }}
            </div>
        @endif


        @push('css')
            <!-- CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
        @endpush


        <div class="col-md-12">
            <a href="{{ url('/documentacion-sgi') }}"
                class="col-md-3 btn btn-lg btn-light border border-primary shadow-sm m-2 w-auto">
                Regresar
            </a>
        </div>




        <br>

        <h3 class="text-center my-1">Mis Aprobaciones</h3>


        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="documentacion-sgi" class="table table-light table-bordered table-hover text-center">
                        <thead class="thead-light">
                            <tr>
                                <th class="col-md-1 text-center">CODIGO</th>
                                <th class="col-md-1 text-center">NOMBRE</th>
                                <th class="col-md-1 text-center">VER</th>
                                <th class="col-md-1 text-center">DESCARGAR</th>
                                <th class="col-md-1 text-center">AUTORIZAR</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td>{{ $document->code }}</td>
                                    <td>{{ $document->name }}</td>

                                    {{-- Columna PDF --}}
                                    {{-- <td>
            @if ($document->file_path_pdf)
                <a href="{{ route('documentos.download', ['type' => 'pdf', 'id' => $document->id]) }}"
                   class="btn btn-sm btn-outline-danger" target="_blank">
            <i class="bi bi-filetype-pdf"  style="font-size: 30px; width: 24px; height: 24px;"></i>
                    
                </a>
            @else
                <span class="text-muted"></span>

            @endif
        </td> --}}
                                    <td>
                                        <a href="{{ url('pdfjs/web/viewer.html?file=' . urlencode(route('documentos.streampdf', ['id' => $document->id]))) }}"
                                            class="btn btn-sm btn-outline-danger" target="_blank">
                                            <i class="bi bi-filetype-pdf"
                                                style="font-size: 30px; width: 24px; height: 24px;"></i>
                                        </a>

                                    </td>

                                    {{-- Columna Documento --}}
                                    <td>

                                        @if ($document->file_path_doc)
                                            <a href="{{ route('documentos.download', ['type' => 'doc', 'id' => $document->id]) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="bi bi-cloud-download"
                                                    style="font-size: 30px; width: 24px; height: 24px;"></i>
                                            </a>
                                        @else
                                            <span class="text-muted"></span>
                                        @endif
                                    </td>

                                       <td>
                                        {{-- <a href="{{ url('documentacion-sgi/' . $document->id . '/edit') }}" --}}
                                        <a href="#"

                                            {{-- target="_blank"  --}} class="btn btn-warning mb-2 text-white">
                                            AUTORIZAR
                                        </a>

                                    </td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            $('#documentacion-sgi').DataTable({
                resposive: true,
                autoWidth: false,
                pageLength: 25,
                order: [
                    [0, 'desc']
                ],

                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "search": "Buscar:",
                    "zeroRecords": "Registro no encontrado - Verifica el texto, elimina espacios al inicio y al final",
                    "paginate": {
                        "first": "Inicio",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "orderable": "Ordenado por esta columna",
                        "orderableReverse": "Columna ordenada inversamente"
                    }
                }
            }); // Asegúrate de que el ID coincida con tu tabla
        });
    </script>
@endpush
