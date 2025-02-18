<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-aceptar {
            background-color: #28a745;
            color: white;
        }
        .btn-cancelar {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Términos y Condiciones</h2>
        <p>
            Bienvenido/a a nuestro sitio web. Antes de utilizar nuestros servicios, te pedimos que leas detenidamente los siguientes términos y condiciones.
        </p>
        <p>
            1. Uso adecuado: No puedes utilizar este sitio para actividades ilegales o no autorizadas.  
            2. Privacidad: No compartiremos tu información con terceros sin tu consentimiento.  
            3. Modificaciones: Nos reservamos el derecho de cambiar estos términos en cualquier momento.  
        </p>
        <p>
            Si aceptas estos términos, haz clic en "Aceptar". Si no estás de acuerdo, haz clic en "Cancelar".
        </p>

        <div class="btn-container">
            <button class="btn btn-aceptar" onclick="aceptarTerminos()">Aceptar</button>
            <button class="btn btn-cancelar" onclick="cancelarTerminos()">Cancelar</button>
        </div>
    </div>

    <script>
        function aceptarTerminos() {
            Swal.fire({
                icon: 'success',
                title: 'Términos aceptados',
                text: 'Redirigiendo a la página de registro...',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'registro.php';
            });
        }

        function cancelarTerminos() {
            Swal.fire({
                icon: 'error',
                title: 'Términos rechazados',
                text: 'No puedes continuar sin aceptar los términos.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'registro.php'; // Cambia aquí si deseas otra acción
            });
        }
    </script>

</body>
</html>
