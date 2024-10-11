<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Consulta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('imagenes/1.jpg'); /* Cambia aquí la ruta según tu estructura de carpetas */
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
            position: relative;
            z-index: 1;
        }

        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .video-iframe {
            width: 100%;
            height: 100%;
        }

        h1 {
            color: #336699;
            text-align: center;
            margin: 20px 0;
        }

        .result {
            margin-bottom: 10px;
        }

        strong {
            color: #336699;
        }

        a {
            display: block;
            text-align: center;
            color: #ffffff;
            background-color: #336699;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            width: 150px;
            margin: 20px auto;
        }

        a:hover {
            background-color: #1c4966;
        }

        .button-container {
            text-align: center;
        }

        .button-container a {
            display: inline-block;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado de la Consulta</h1>
        <?php
        // Datos de conexión a la base de datos
        $servername = "localhost";
        $username = "Francisco1234";
        $password = "1234";
        $dbname = "productos"; // Nombre de la base de datos "productos"

        // Código ingresado por el usuario
        $producto_codigo = $_POST['codigo']; // Asegúrate de validar y sanitizar esta entrada para evitar ataques de inyección SQL.

        // Crear la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta para obtener el precio del producto y el campo neto
        $sql = "SELECT descripcion, precio_total, neto FROM productos WHERE codigo = '$producto_codigo'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar los resultados
            $row = $result->fetch_assoc();
            $nombre_producto = $row["descripcion"];
            $campo_neto = $row["neto"];
            $precio_producto = $row["precio_total"];
        } else {
            $nombre_producto = "No encontrado";
            $precio_producto = "No encontrado";
            $campo_neto = "No encontrado";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
        <div class="result">
            <strong>Nombre del producto:</strong> <?php echo $nombre_producto; ?>
        </div>
        <div class="result">
            <strong>Neto: $</strong> <?php echo $campo_neto; ?>
        </div>
        <div class="result">
            <strong>Precio: $</strong> <?php echo $precio_producto; ?>
        </div>
        <div class="button-container">
            <a href="index.html">otra busqueda</a>
            <a href="index.html">Buscar por Nombre</a>
        </div>
    </div>
</body>
</html>
