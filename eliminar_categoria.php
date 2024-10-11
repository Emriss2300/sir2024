<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Categoría</title>
</head>
<body>
    <h2>Eliminar Categoría</h2>
    <form method="post" action="">
        <label for="codigo">Código de Categoría a eliminar:</label>
        <input type="text" id="codigo" name="codigo" required>
        <input type="submit" value="Eliminar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $codigoEliminar = $_POST["codigo"];

        $servername = "localhost";
        $username = "Francisco1234";
        $password = "1234";
        $dbname = "productos";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "DELETE FROM categorias WHERE codigo = '$codigoEliminar'";

        if ($conn->query($sql) === TRUE) {
            echo "Categoría eliminada con éxito.";
        } else {
            echo "Error al eliminar la categoría: " . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
