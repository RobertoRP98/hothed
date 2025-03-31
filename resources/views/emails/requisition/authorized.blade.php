<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Requisición</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: rgba(15, 57, 93, 255);
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .content {
            padding: 25px;
            text-align: left;
            color: #333;
        }

        .content h2 {
            color: rgba(15, 57, 93, 255);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .highlight {
            font-weight: bold;
            color: rgba(15, 57, 93, 255);
        }

        .cta-button {
            text-align: center;
            margin: 20px 0;
        }

        .cta-button a {
            text-decoration: none;
            background-color: rgba(15, 57, 93, 255);
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            display: inline-block;
        }

        .cta-button a:hover {
            background-color: rgba(15, 57, 93, 0.8);
        }

        .footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .footer a {
            color: rgba(15, 57, 93, 255);
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .image-container {
            text-align: center;
            padding: 15px 0;
        }

        .image-container img {
            max-width: 180px;
            height: auto;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <h1>Notificación de Nueva Requisición Autorizada</h1>
        </div>

        <!-- Contenido -->
        <div class="content">
          
            <h2>Detalles de la Requisición</h2>
            <p><strong>¡Hola! esta requisición esta lista para tener una orden de compra</strong></p>
            <p><strong>Solicitante:</strong> <span class="highlight">{{ $requisition->user->name }}</span></p>
            <p><strong>Fecha:</strong> <span class="highlight">{{ $requisition->request_date }}</span></p>
            <p><strong>Importancia:</strong> <span class="highlight">{{ $requisition->importance }}</span></p>
            
            <div class="cta-button">
                <a href="https://adminhothedmex.mx/">Pulse Aqui Para Crear Orden de Compra</a>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>&copy; 2024 hothedmex.mx. Todos los derechos reservados.</p>
            <p>Si tienes preguntas, contáctanos en <a href="mailto:digital@hothedmex.mx">digital@hothedmex.mx</a>.</p>
        </div>
    </div>
</body>
</html>
