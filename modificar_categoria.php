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
        
        <!-- Agrega más campos de categoría aquí según tu estructura de base de datos -->

        <input type="submit" value="Agregar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["codigo"]) && isset($_POST["categoria"])) {
            $nuevoCodigo = $_POST["codigo"];
            $nuevaCategoria = $_POST["categoria"];

            $servername = "localhost";
            $username = "Francisco1234";
            $password = "1234";
            $dbname = "productos";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $verificar_sql = "SELECT COUNT(*) as count FROM categorias WHERE codigo = '$nuevoCodigo'";
            $verificar_result = $conn->query($verificar_sql);
            $verificar_row = $verificar_result->fetch_assoc();

            if ($verificar_row['count'] > 0) {
                echo "El código ya existe en la base de datos.";
            } else {
                $sql = "INSERT INTO categorias (codigo, categoria) VALUES ('$nuevoCodigo', '$nuevaCategoria')";

                if ($conn->query($sql) === TRUE) {
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
</body>
</html>
