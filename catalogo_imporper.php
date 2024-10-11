<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px 0px #888888;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .highlight {
            background-color: yellow;
        }

        /* Estilos para el botón de volver */
        .btn-volver {
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <h1>Consulta de Productos del Catálogo IMPORPER</h1>
    <div class="container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = ""; // Deja la contraseña en blanco si no la has configurado
        $dbname = "productos";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $busqueda = "";

        if (isset($_POST['buscar'])) {
            $busqueda = $_POST['busqueda'];
            $sql = "SELECT * FROM catalogo_imporper WHERE codigo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' ORDER BY codigo ASC";
        } else {
            $sql = "SELECT * FROM catalogo_imporper ORDER BY codigo ASC";
        }

        $result = $conn->query($sql);

        echo "<form method='POST'>";
        echo "<input type='text' name='busqueda' placeholder='Buscar por código o descripción' value='$busqueda'>";
        echo "<input type='submit' name='buscar' value='Buscar'>";
        echo "</form>";

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Código</th><th>Descripción</th><th>Unidad de Venta</th><th>Unidad de Almacenamiento</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $codigo = $row["codigo"];
                $descripcion = $row["descripcion"];
                $uni_venta = $row["uni_venta"];
                $uni_almacenamiento = $row["uni_almacenamiento"];

                // Resaltar caracteres buscados en amarillo
                $codigo = str_ireplace($busqueda, "<span class='highlight'>$busqueda</span>", $codigo);
                $descripcion = str_ireplace($busqueda, "<span class='highlight'>$busqueda</span>", $descripcion);

                echo "<tr><td>$codigo</td><td>$descripcion</td><td>$uni_venta</td><td>$uni_almacenamiento</td></tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron resultados en la tabla 'catalogo_imporper'.";
        }

        $conn->close();
        ?>
    </div>
    <!-- Botón de Volver -->
    <a class="btn-volver" href="http://localhost/consulta/administracion/index.php">Volver</a>
</body>
</html>
