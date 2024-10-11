<!DOCTYPE html>
<html>
<head>
    <title>Agregar Categoría</title>
</head>
<body>
    <h2>Agregar Nueva Categoría</h2>
    <form method="post" action="">
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required><br>
        
        <label for="categoria">Nombre de la Categoría:</label>
        <input type="text" id="categoria" name="categoria" required><br>

        <input type="submit" value="Agregar">
    </form>

    <?php
    // Define las variables de conexión antes de usarlas
    $servername = "localhost";
    $username = "Francisco1234";
    $password = "1234";
    $dbname = "productos";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["codigo"]) && isset($_POST["categoria"])) {
            $nuevoCodigo = $_POST["codigo"];
            $nuevaCategoria = $_POST["categoria"];

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Verificar si el código ya existe en la base de datos
            $checkSql = "SELECT codigo FROM categorias WHERE codigo = '$nuevoCodigo'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                echo "El código ya existe en la base de datos.";
            } else {
                // Insertar la nueva categoría sin el campo "Código de Categoría"
                $insertSql = "INSERT INTO categorias (codigo, categoria) VALUES ('$nuevoCodigo', '$nuevaCategoria')";

                if ($conn->query($insertSql) === TRUE) {
                    echo "Categoría agregada con éxito.";
                } else {
                    echo "Error al agregar la categoría: " . $conn->error;
                }
            }

            $conn->close();
        } else {
            echo "Los campos 'codigo' y 'categoria' son requeridos.";
        }
    }
    ?>

    <h2>Categorías Actuales</h2>
    <table border="1">
        <tr>
            <th>Código</th>
            <th>Nombre de la Categoría</th>
        </tr>
        <?php
        // Vuelve a definir las variables de conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT codigo, categoria FROM categorias";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["codigo"] . "</td>";
                echo "<td>" . $row["categoria"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "No hay categorías disponibles.";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
