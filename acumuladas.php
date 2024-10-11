<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETIQUETAS ACUMULATIVA MULTIPLE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            font-size: 36px;
        }

        fieldset {
            border: 5px solid #007bff;
            padding: 20px;
            border-radius: 5px;
            background-color: #ffffff;
        }

        .entrada {
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 5px solid #ccc;
            border-radius: 5px;
        }

        button,
        .back-button {
            display: block; /* Para que se comporten como botones */
            width: 100%; /* Ancho completo */
            height: 30px; /* Altura reducida */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
            font-size: 14px; /* Tamaño de fuente reducido */
            text-align: center; /* Centrar texto */
            text-decoration: none; /* Sin subrayado */
        }

        button {
            background-color: #007bff; /* Color de fondo para todos los botones */
        }

        button:hover {
            background-color: #0056b3; /* Color de fondo al pasar el ratón */
        }

        .back-button {
            background-color: red; /* Color de fondo para el botón Volver */
        }

        .back-button:hover {
            background-color: darkred; /* Color de fondo al pasar el ratón sobre el botón Volver */
        }

        .etiquetas-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Centra las etiquetas */
            margin-top: 20px; /* Espacio entre el formulario y las etiquetas */
        }

        .etiqueta {
            border: 5px solid #ccc;
            padding: 0; /* Eliminado padding */
            margin: 0; /* Eliminado margen */
            display: inline-block;
            text-align: center;
            width: 200px; /* Ancho fijo */
            height: 150px; /* Alto fijo para todas las etiquetas */
            box-sizing: border-box; /* Incluye el padding en el tamaño total */
            border-radius: 5px; /* Bordes redondeados */
            background-color: #ffffff; /* Fondo blanco */
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Sombra suave */
        }

        .etiqueta h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #007bff; /* Color del título */
        }
    </style>
</head>
<body>
    <h1>Generador de Etiquetas Multiples</h1>

    <form method="post" action="">
        <fieldset>
            <legend>Datos de la Etiqueta</legend>
            <div id="entradas">
                <div class="entrada">
                    <label for="codigo">Ingrese código:</label>
                    <input type="text" name="entradas[0][codigo]" required>
                    <label for="cantidad">Cantidad de etiquetas:</label>
                    <input type="number" name="entradas[0][cantidad_etiquetas]" required min="1">
                </div>
            </div>
            <button type="button" onclick="agregarEntrada()">Agregar más</button>
            <button type="submit">Generar Etiquetas</button>
            <a class="back-button" href="http://localhost/consulta/administracion/index.php">Volver</a>
        </fieldset>
    </form>

    <script>
        function agregarEntrada() {
            const entradasDiv = document.getElementById('entradas');
            const index = entradasDiv.children.length;
            const nuevaEntrada = document.createElement('div');
            nuevaEntrada.className = 'entrada';
            nuevaEntrada.innerHTML = `
                <label for="codigo">Ingrese código:</label>
                <input type="text" name="entradas[${index}][codigo]" required>
                <label for="cantidad">Cantidad de etiquetas:</label>
                <input type="number" name="entradas[${index}][cantidad_etiquetas]" required min="1">
            `;
            entradasDiv.appendChild(nuevaEntrada);
        }

        function imprimirEtiquetas() {
            const etiquetasContainer = document.querySelector('.etiquetas-container');
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Imprimir Etiquetas</title>');
            printWindow.document.write('<style>'); // Agregar CSS
            printWindow.document.write(`
                body {
                    font-family: Arial, sans-serif;
                }
                .etiquetas-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                }
                .etiqueta {
                    border: 5px solid #ccc;
                    padding: 0; /* Eliminado padding */
                    margin: 0; /* Eliminado margen */
                    display: inline-block;
                    text-align: center;
                    width: 200px; /* Ancho fijo */
                    height: 150px; /* Alto fijo */
                    box-sizing: border-box;
                    border-radius: 5px;
                    background-color: #ffffff;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                }
                .etiqueta h2 {
                    margin: 5px 0;
                    font-size: 16px;
                    color: #007bff;
                }
            `);
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(etiquetasContainer.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "Francisco1234";
        $password = "1234";
        $dbname = "productos";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $entradas = $_POST['entradas'];
        echo "<div class='etiquetas-container'>"; // Contenedor para las etiquetas
        foreach ($entradas as $entrada) {
            $codigo = mysqli_real_escape_string($conn, $entrada['codigo']);
            $cantidadEtiquetas = intval($entrada['cantidad_etiquetas']);
            
            if ($cantidadEtiquetas > 0) {
                $sql = "SELECT * FROM productos WHERE codigo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $codigo);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        for ($i = 0; $i < $cantidadEtiquetas; $i++) {
                            echo "<div class='etiqueta'>";
                            echo "<h2 class='codigo'>Código: {$row['codigo']}</h2>";
                            echo "<p class='descripcion'>Descripción: {$row['descripcion']}</p>";
                            echo "<p class='total'>Precio Uni.: $ {$row['precio_total']}</p>";
                            echo "</div>";
                        }
                    }
                } else {
                    echo "<p>No se encontró ningún producto con el código: $codigo.</p>";
                }
            }
        }
        echo "</div>"; // Cierre del contenedor de etiquetas
        
        // Botón para imprimir etiquetas
        echo "<button onclick='imprimirEtiquetas()'>Imprimir Etiquetas</button>";
        
        $conn->close();
    }
    ?>
</body>
</html>
