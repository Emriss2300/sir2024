<!DOCTYPE html>
<html>
<head>
    <title>ETIQUETAS PARA AUTOPERFORANTES</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 0;
        }

        @font-face {
            font-family: 'barcode39';
            src: url('barcode39.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Bar-Code 39';
            src: url('barcode39.ttf') format('truetype');
        }

        label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="color"],
        input[type="submit"],
        button {
            width: 100%;
            padding: 0px;
            margin-bottom: 10px;
        }

        input[type="submit"],
        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .color-selectors {
            display: flex;
            margin-bottom: 10px;
        }

        .color-selector {
            margin-right: 10px;
        }

        .color-selector .color-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #ccc;
        }

        .etiqueta {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 0; /* Elimina el margen */
            display: inline-block;
            text-align: center;
            box-sizing: border-box; /* Incluye padding y border en el tamaño total */
        }

        .etiqueta img {
            max-width: 100px; /* Ajusta el tamaño del logo si es necesario */
            max-height: 50px; /* Ajusta el tamaño del logo si es necesario */
            margin-bottom: 10px;
        }

        .etiqueta h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #Ff0000;
            font-family: 'Arial', sans-serif;
        }

        .etiqueta p {
            margin: 5px 0;
            font-size: 16px;
            color: #000;
        }

        @media print {
            .no-print {
                display: none;
            }

            .formulario {
                display: none;
            }

            .etiqueta {
                page-break-inside: avoid; /* Evita saltos de página dentro de las etiquetas */
            }
        }

        h1 {
            text-align: center;
            font-size: 36px;
        }

        .header {
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 0;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .ancho-imagen {
            width: 150px; /* Ajusta el valor a la anchura deseada */
        }
    </style>
    
</head>
<body>
    <div class="header">
        <!-- Puedes agregar contenido en el encabezado si lo deseas -->
    </div>
    
    <form method="post" action="" class="formulario">
        <fieldset>
            <legend>Datos de la Etiqueta</legend>
            <label for="codigo">Ingrese código:</label>
            <input type="text" id="codigo" name="codigo" required>

            <label for="cantidad">Cantidad de etiquetas:</label>
            <input type="number" id="cantidad" name="cantidad_etiquetas" required>

            <label for="cantidad_por_bolsa">Cantidad por bolsa:</label>
            <input type="text" id="cantidad_por_bolsa" name="cantidad_por_bolsa" required>

            <label for="ancho_etiqueta_cm">Ancho de etiqueta (cm):</label>
            <input type="number" id="ancho_etiqueta_cm" name="ancho_etiqueta_cm" step="0.1" min="1" value="3">

            <label for="largo_etiqueta_cm">Largo de etiqueta (cm):</label>
            <input type="number" id="largo_etiqueta_cm" name="largo_etiqueta_cm" step="0.1" min="1" value="1">

            <div class="color-selectors">
                <label for="codigo_color" class="color-selector">
                    Color del Texto:
                    <div class="color-circle" id="codigo_selector" style="background-color: #000000;"></div>
                    <input type="color" id="codigo_color" name="codigo_color" value="#000000" class="color-input" onchange="actualizarSelectorColor(this, 'codigo_selector')">
                </label>
                <label for="fondo_color" class="color-selector">
                    Color de Fondo:
                    <div class="color-circle" id="fondo_selector" style="background-color: #f9f9f9;"></div>
                    <input type="color" id="fondo_color" name="fondo_color" value="#f9f9f9" class="color-input" onchange="actualizarSelectorColor(this, 'fondo_selector')">
                </label>
            </div>

            <label for="tamano_fuente_codigo">Tamaño de Fuente del Texto:</label>
            <input type="range" id="tamano_fuente_codigo" name="tamano_fuente_codigo" min="5" max="40" value="16" oninput="actualizarTamanioFuente(this.value)">
            <output for="tamano_fuente_codigo" id="tamano_fuente_codigo_output">16</output>
        </fieldset>
        <input type="submit" value="Generar Etiquetas" class="no-print">
    </form>

    <button class="no-print" onclick="imprimirEtiquetas()">Imprimir Etiquetas</button>

    <script>
        function imprimirEtiquetas() {
            document.querySelector(".no-print").style.display = "none";
            window.print();
            document.querySelector(".no-print").style.display = "block";
        }

        var tamanoFuenteCodigoInput = document.getElementById("tamano_fuente_codigo");
        var tamanoFuenteCodigoOutput = document.getElementById("tamano_fuente_codigo_output");

        tamanoFuenteCodigoInput.addEventListener("input", function () {
            actualizarTamanioFuente(this.value);
            tamanoFuenteCodigoOutput.value = this.value;
        });

        var codigoColorInput = document.getElementById("codigo_color");
        var fondoColorInput = document.getElementById("fondo_color");

        codigoColorInput.addEventListener("input", actualizarColores);
        fondoColorInput.addEventListener("input", actualizarColores);

        function actualizarColores() {
            var textoColor = codigoColorInput.value;
            var fondoColor = fondoColorInput.value;

            var etiquetas = document.getElementsByClassName("etiqueta");
            for (var i = 0; i < etiquetas.length; i++) {
                etiquetas[i].style.color = textoColor;
                etiquetas[i].style.backgroundColor = fondoColor;
            }
        }

        function actualizarSelectorColor(inputColor, selectorId) {
            var color = inputColor.value;
            var selector = document.getElementById(selectorId);
            selector.style.backgroundColor = color;
            actualizarColores();
        }

        function actualizarTamanioFuente(valor) {
            var tamanioFuente = valor + "px";
            var etiquetas = document.getElementsByClassName("etiqueta");
            for (var i = 0; i < etiquetas.length; i++) {
                var textos = etiquetas[i].getElementsByTagName("p");
                for (var j = 0; j < textos.length; j++) {
                    textos[j].style.fontSize = tamanioFuente;
                }
                var titulos = etiquetas[i].getElementsByTagName("h2");
                for (var k = 0; k < titulos.length; k++) {
                    titulos[k].style.fontSize = tamanioFuente;
                }
            }
        }
    </script>

    <?php
    $servername = "localhost";
    $username = "Francisco1234";
    $password = "1234";
    $dbname = "productos";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener y sanitizar datos del formulario
        $codigo = isset($_POST['codigo']) ? $conn->real_escape_string($_POST['codigo']) : '';
        $cantidadEtiquetas = isset($_POST['cantidad_etiquetas']) ? (int)$_POST['cantidad_etiquetas'] : 0;
        $cantidadPorBolsa = isset($_POST['cantidad_por_bolsa']) ? $conn->real_escape_string($_POST['cantidad_por_bolsa']) : '';
        $anchoEtiquetaCm = isset($_POST['ancho_etiqueta_cm']) ? (float)$_POST['ancho_etiqueta_cm'] : 3.0;
        $largoEtiquetaCm = isset($_POST['largo_etiqueta_cm']) ? (float)$_POST['largo_etiqueta_cm'] : 1.0;
        $codigoColor = isset($_POST['codigo_color']) ? $conn->real_escape_string($_POST['codigo_color']) : '#000000';
        $fondoColor = isset($_POST['fondo_color']) ? $conn->real_escape_string($_POST['fondo_color']) : '#f9f9f9';
        $tamanoFuenteCodigo = isset($_POST['tamano_fuente_codigo']) ? (int)$_POST['tamano_fuente_codigo'] : 16;

        if (!empty($codigo)) {
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare("SELECT descripcion FROM productos WHERE codigo = ?");
            $stmt->bind_param("s", $codigo);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                $descripcion = $row['descripcion'];

                // Generar etiquetas
                for ($i = 0; $i < $cantidadEtiquetas; $i++) {
                    echo "<div class='etiqueta' style='background-color: {$fondoColor}; color: {$codigoColor};'>";
                    echo "<img src='imagenes/2.png' alt='Logo'>"; // Añadir el logo
                    echo "<h2>{$descripcion}</h2>";
                    echo "<p>Código: {$codigo}</p>";
                    echo "<p>Cantidad: {$cantidadPorBolsa} un.</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No se encontraron resultados para el código: {$codigo}</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Por favor, ingresa un código válido.</p>";
        }
    }

    $conn->close();
    ?>
</body>
</html>
