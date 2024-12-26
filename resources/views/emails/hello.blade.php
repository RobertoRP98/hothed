<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación Empresarial</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #003366;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            color: #333333;
            font-size: 20px;
            margin-top: 0;
        }

        .content p {
            color: #555555;
            line-height: 1.6;
        }

        .content .cta-button {
            display: block;
            text-align: center;
            margin: 20px 0;
        }

        .cta-button a {
            text-decoration: none;
            background-color: #003366;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .cta-button a:hover {
            background-color: #00509e;
        }

        .footer {
            background-color: #f1f1f1;
            padding: 10px 20px;
            text-align: center;
            font-size: 12px;
            color: #666666;
        }

        .footer p {
            margin: 0;
        }

        .image-container {
            text-align: center;
            margin: 20px 0;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>adminhothedmex.mx</h1>
            <p>Test de automatización</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Hola</h2>
            <p>
                Queremos informarte sobre los cambios recientes en nuestras políticas y procesos para ofrecerte un mejor servicio. 
                Por favor, revisa los detalles a continuación:
            </p>
            <div class="image-container">
                <img src="{{ $message->embed('https://adminhothedmex.mx/images/logo.png') }}" alt="Imagen">
            </div>
            <p><strong>Resumen de cambios:</strong></p>
            <ul>
                <li>Test 1</li>
                <li>Test 2</li>
                <li>Test 3</li>
            </ul>
            <div class="cta-button">
                <a href="https://adminhothedmex.mx/">Visita</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 hothedmex.mx. Todos los derechos reservados.</p>
            <p>Si tienes preguntas, contáctanos en <a href="mailto:soporte@tuempresa.com">digital@hothedmex.mx</a>.</p>
        </div>
    </div>
</body>
</html>
