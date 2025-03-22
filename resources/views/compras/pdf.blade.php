<html>

<head>
    <style>
       @page {
    size: A4;
    margin: 20px;
}

body {
    font-family: Arial, sans-serif;
    color: #333;
    position: relative;
}

        /* 🔹 Cabecera */
        .header-table {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        /* 🔹 Tablas */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            table-layout: fixed; /* 📌 Para evitar que se deforme */
        }

        .table th,
        .table td {
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            padding: 8px;
            white-space: normal; /* 📌 Evita saltos de línea en fechas */
            word-wrap: break-word;
            overflow-wrap: break-word; /* ✅ Alternativa para navegadores más modernos */
        }

        .table th {
           /* background-color: #2C3E50; */
            /* color: white; */
        }

        /* 🔹 Status Box */
        .status-box {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 10px;
        }

        /* 🔹 Corrección para Logo en PDF */
        .logo {
            width: 100px;
            height: auto;
        }

       /* 🔹 Marca de Agua en TODAS las páginas */
.watermark-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-content: center;
    opacity: 0.1;
}

.watermark-container span {
    font-size: 50px;
    font-weight: bold;
    transform: rotate(-30deg);
    display: inline-block;
    text-align: center;
}

.no-decoration {
    border: none !important;
    background-color: transparent !important;
}

.text-left {
    text-align: left;
}

.scale-container {
    transform: scale(0.9); /* 🔹 Ajusta el tamaño sin deformar */
    transform-origin: top center; /* 🔹 Mantiene el centrado */
}

.table {
    table-layout: auto !important;
}
    </style>
</head>

<body>
    <div class="scale-container">
    <!-- ✅ Cabecera -->
    <table class="header-table">
        <tr>
            <img src="{{ public_path('images/logopdf.png') }}" class="logo" alt="HOT HED">

            <td>
                <h1 style="margin: 0;">ORDEN DE COMPRA</h1>
            </td>
            <td>
                <p style="margin: 0;">HOT HED MÉXICO S.A DE C.V</p>
            </td>
        </tr>
    </table>

    <!-- ✅ Datos Generales -->
    <table class="table">
        <tbody>
            <tr>
                <th>COMPRADOR</th>
                <td>{{ $proveedorhh->name }}</td>
                <th>PROVEEDOR</th>
                <td>{{ $initialData['supplierData'][0]['name'] }}</td>

            </tr>
            <tr>
                <th>DIRECCIÓN DE ENVIO</th>
                <td>{{ $proveedorhh->address }}</td>
                <th>DATOS DEL PROVEEDOR</th>
                <td><strong>DIRECCIÓN:</strong> {{ $initialData['supplierData'][0]['address'] }} <br>
                    <strong>RFC:</strong> {{ $initialData['supplierData'][0]['rfc'] }} <br>
                    <strong>CUENTA BANCARIA:</strong> {{ $initialData['supplierData'][0]['account'] }} </td>
            </tr>
        </tbody>
    </table>

       <!-- FECHAS -->
       <table class="table">
        <tbody>
            <tr>
                <td>ORDEN DE COMPRA #{{ $initialData['formData']['order'] }}</td>
                <td>FECHA DE SOLICITUD: {{ date('d-m-Y', strtotime($initialData['formData']['date_start'])) }}</td>
                <td>PRIORIDAD DE SOLICITUD: {{ $initialData['formData']['prioridad'] }}</td>
                <td>FECHA LIMITE DE COMPRA: {{ date('d-m-Y', strtotime($initialData['formData']['production_date'])) }}</td>

            </tr>
          
        </tbody>
    </table>


    

    <!-- ✅ Tabla de Productos -->
    <table class="table">
            <tr>
                <th>PROD.</th>
                <th>CANTIDAD</th>
                <th>PRECIO</th>
                <th>IMPUESTO</th>
                <th>DESCT.</th>
                <th>IMPORTE</th>

            </tr>
        <tbody>
            @foreach($initialData['productData'] as $product)
            <tr>
                <td>{{ $product['description'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>${{ $product['price'] }}</td>
                <td>{{ $product['tax']['concept'] }}</td> <!-- ✅ Corrección aquí -->
                <td>{{ $product['discount'] }}%</td>
                <td>${{ $product['subtotalproducto'] }}</td>
            </tr>
            @endforeach

            <tr>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td>SUB-TOTAL</td>
                <td>${{ $initialData['formData']['subtotal'] }}</td>
            </tr>
            <tr>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td>IVA</td>
                <td>${{ $initialData['formData']['tax'] }}</td>
            </tr>     
            <tr>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td>DESCUENTO</td>
                <td>${{ $initialData['formData']['total_descuento'] }}</td>
            </tr>     
            <tr>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td class="no-decoration"></td>
                <td>TOTAL</td>
                <td>${{ $initialData['formData']['total'] }}</td>
            </tr>
        </tbody>
    </table>


     <!-- FIRMA -->
     @if ($initialData['formData']['authorization_4']  == 'Pendiente')
        <table class="table">
            <tbody>
                <tr>
                <td class="no-decoration"><{{ $initialData['formData']['authorization_4'] }}></td>
                </tr>
                <tr>
                    <td class="no-decoration">TU SOLICITUD ESTA EN ESPERA DE AUTORIZACIÓN</td>
                </tr>
              
            </tbody>
        </table>
     @elseif ($initialData['formData']['authorization_4']  == 'Rechazado')
        <table class="table">
            <tbody>
                <tr>
                <td class="no-decoration">{{ $initialData['formData']['authorization_4'] }}</td>
                </tr>
                <tr>
                    <td class="no-decoration">TU SOLICITUD HA SIDO RECHAZADA</td>
                </tr>
            </tbody>
        </table>
     @elseif( $initialData['formData']['authorization_4']  == 'Autorizado')
     <table class="table">
        <tbody>
            <tr>
                <td class="no-decoration">
            <img src="{{ public_path('images/firmapdf.png') }}" alt="HOT HED" style="width: 200px; height: auto;">

        </td>
            </tr>
            <tr>
                <td class="no-decoration">AUTORIZADO POR DIR. KARLA I. SEGURA GÓMEZ</td>
            </tr>
          
        </tbody>
    </table> 
     @endif

     <table class="table">
        <tbody>
            <tr>
                <td class="no-decoration"></td>
            </tr>
            <tr>
                <td class="no-decoration">
                <p style="margin: 0;">www.hothedmexico.mx</p>
            </td>

            </tr>
        </tbody>
    </table>

    

{{-- <!-- ✅ Contenedor de la marca de agua en TODAS las páginas -->
<div class="watermark-container">
    @for ($i = 0; $i < 36; $i++) <!-- 🔥 Más iteraciones para llenar cada página -->
    <span>{{ strtoupper($initialData['formData'][''authorization_4''])}}</span>
    @endfor
</div> --}}


</div>
</body>

</html>