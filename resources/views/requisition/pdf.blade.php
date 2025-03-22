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
           /* white-space: nowrap;  📌 Evita saltos de línea en fechas */
            word-wrap: break-word;
        }

        .table th {
            background-color: #2C3E50;
            color: white; 
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
    </style>
</head>

<body>

    <!-- ✅ Cabecera -->
    <table class="header-table">
        <tr>
            <td><img src="{{ public_path('images/logopdf.png') }}" class="logo" alt="HOT HED"></td>
            <td>
                <h1 style="margin: 0;">REQUISICIÓN</h1>
            </td>
            <td>
                <p style="margin: 0;">ADM-7-FOR-02 | Versión: x</p>
            </td>
        </tr>
    </table>

    <!-- ✅ Datos Generales -->
    <table class="table">
        <tbody>
            <tr>
                <th>PROYECTO</th>
                <td>{{ $initialData['formData']['notes_client'] }}</td>
                <th>REQUISICIÓN </th>
                <td>#{{ $initialData['formData']['id'] }} - {{ $initialData['formData']['dep_user'] }}</td>
            </tr>
            <tr>
                <th>FECHA DE SOLICITUD</th>
                <td>{{ date('d-m-Y', strtotime($initialData['formData']['request_date'])) }}</td>
                <th>FECHA REQUERIDA</th>
                <td>{{ date('d-m-Y', strtotime($initialData['formData']['required_date'])) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- ✅ Tabla de Productos -->
    <table class="table">
        <thead>
            <tr>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
            </tr>
        </thead>
        <tbody>
            @foreach($initialData['productData'] as $product)
            <tr>
                <td>{{ $product['description'] }}</td>
                <td>{{ $product['quantity'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ✅ Status de la Requisición -->
    <div class="status-box">
        STATUS DE REQUISICIÓN #{{ $initialData['formData']['id'] }} :  <strong>{{ $initialData['formData']['status_requisition'] }}</strong>
    </div>

{{-- <!-- ✅ Contenedor de la marca de agua en TODAS las páginas -->
<div class="watermark-container">
    @for ($i = 0; $i < 36; $i++) <!-- 🔥 Más iteraciones para llenar cada página -->
    <span>{{ strtoupper($initialData['formData']['status_requisition'])}}</span>
    @endfor
</div> --}}


</body>

</html>