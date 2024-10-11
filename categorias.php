<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos por Categoría</title>
    
    <style>

    </style>
</head>
<body>
    <h1>Productos por Categoría</h1>

    <!-- Formulario para seleccionar la categoría -->
    <form method="post" action="">
        <label for="categoria">Selecciona una Categoría:</label>
        <select name="categoria" id="categoria">
            <?php
            // Configura la conexión a la base de datos (reemplaza con tus propios datos)
            $servername = "localhost";
            $username = "Francisco1234";
            $password = "1234";
            $dbname = "productos";

            // Crea una conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta SQL para obtener todas las categorías disponibles
            $sql = "SELECT DISTINCT categoria FROM categorias";

            // Ejecuta la consulta
            $result = $conn->query($sql);

            // Genera las opciones de la lista desplegable
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["categoria"] . "'>" . $row["categoria"] . "</option>";
            }

            // Cierra la conexión
            $conn->close();
            ?>
        </select>
        <input type="submit" value="Mostrar Productos">
    </form>

    <?php
    // Procesa la selección de categoría cuando se envía el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si la clave 'categoria' está definida en $_POST
        if (isset($_POST["categoria"])) {
            // Obtén la categoría seleccionada
            $categoriaSeleccionada = $_POST["categoria"];

            // Conexión a la base de datos (de nuevo)
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta SQL para obtener los productos de la categoría seleccionada
            $sql = "SELECT p.codigo AS producto_codigo, p.descripcion AS producto_descripcion, p.precio_total AS precio, p.codigo_barra AS codigo_barra
                    FROM productos p
                    INNER JOIN categorias c ON p.codigo = c.codigo
                    WHERE c.categoria = '$categoriaSeleccionada'";

            // Ejecuta la consulta
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Productos de la Categoría '$categoriaSeleccionada'</h2>";
                echo "<table border='1'>
                    <tr>
                        <th>Código de Producto</th>
                        <th>Descripción de Producto</th>
                        <th>Precio</th>
                        <th>Código de Barras</th> <!-- Agrega la columna del código de barras -->
                    </tr>";

                // Recorre los resultados y muestra cada fila
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["producto_codigo"] . "</td>
                        <td>" . $row["producto_descripcion"] . "</td>
                        <td>" . $row["precio"] . "</td>
                        <td>" . $row["codigo_barra"] . "</td> <!-- Muestra el código de barras -->
                    </tr>";
                }

                echo "</table>";
            } else {
                echo "No se encontraron productos para la categoría '$categoriaSeleccionada'.";
            }

            // Cierra la conexión
            $conn->close();
        } else {
            // Si la clave 'categoria' no está definida en $_POST, muestra un mensaje de error o realiza alguna acción adecuada.
            echo "La categoría no se seleccionó correctamente.";
        }
    }
    ?>

    <!-- Botones de administración de categorías (con enlaces a las páginas correspondientes) -->
    <h3>Administración de Categorias</h3>
    <a href="agregar_categoria.php"><button>Agregar Categoría</button></a>
    <a href="modificar_categoria.php"><button>Modificar Categoría</button></a>
    <a href="eliminar_categoria.php"><button>Eliminar Categoría</button></a>
</body>
</html>
