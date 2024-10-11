<!DOCTYPE html>
<html>
<head>
    <title>Resultados de la Búsqueda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }
        .no-results {
            text-align: center;
            color: #999;
            font-style: italic;
        }
        .search-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .search-button button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        a {
            display: block;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-button">
            <a href="index.html"><button>Realizar otra búsqueda</button></a>
        </div>
        <h1>Resultados de la Búsqueda</h1>

        <?php
        // Datos de conexión a la base de datos
        $servername = "localhost";
        $username = "Francisco1234";
        $password = "1234";
        $dbname = "productos"; // Nombre de la base de datos "productos"

        // Término de búsqueda ingresado por el usuario
        if (isset($_GET['descripcion'])) {
            $buscar_descripcion = $_GET['descripcion']; // Asegúrate de validar y sanitizar esta entrada para evitar ataques de inyección SQL.

            // Crear la conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Consulta para obtener los productos que coinciden con la descripción ingresada
            $sql = "SELECT codigo, descripcion, neto, precio_total FROM productos WHERE descripcion LIKE '%$buscar_descripcion%'";
            $result = $conn->query($sql);

            if ($result === false) {
                die("Error en la consulta: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<tr><th>Código</th><th>Nombre del producto</th><th>Neto</th><th>Precio</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["codigo"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["descripcion"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["neto"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["precio_total"]) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p class="no-results">No se encontraron resultados para la búsqueda: <strong>' . htmlspecialchars($buscar_descripcion) . '.</strong></p>';
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo '<p class="no-results">Por favor, ingresa un término de búsqueda.</p>';
        }
        ?>

    </div>
</body>
</html>

