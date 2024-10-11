<!DOCTYPE html>
<html>
<head>
    <title>Generador de Etiquetas de Precio</title>
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
            margin: 0px;
            display: inline-block;
            text-align: center;
        }

        .etiqueta h2 {
            margin: 0px 0;
            font-size: 16px;
            color: #000;
            font-family: 'Bar-Code 39', sans-serif;
        }

        .etiqueta p {
            margin: 0px 0;
            font-size: 16px;
            color: #000;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        @media print {
            form, button {
                display: none;
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

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    
    
    <form method="post" action="">
        <fieldset>
            <legend>Datos de la Etiqueta</legend>
            <label for="codigo">Ingrese código:</label>
            <input type="text" id="codigo" name="codigo" required>
            <label for="cantidad">Cantidad de etiquetas:</label>
            <input type="number" id="cantidad" name="cantidad_etiquetas" required>
            <label for="ancho_etiqueta_cm">Ancho de etiqueta (cm):</label>
            <input type="number" id="ancho_etiqueta_cm" name="ancho_etiqueta_cm" step="0.1" min="1" value="10">
            <label for="largo_etiqueta_cm">Largo de etiqueta (cm):</label>
            <input type="number" id="largo_etiqueta_cm" name="largo_etiqueta_cm" step="0.1" min="1" value="10">
            <div class="color-selectors">
                <label for="codigo_color" class="color-selector">
                    Color del Código:
                    <div class="color-circle" id="codigo_selector"></div>
                    <input type="color" id="codigo_color" name="codigo_color" value="#000000" class="color-input" onchange="actualizarSelectorColor(this, 'codigo_selector')">
                </label>
                <label for="precio_color" class="color-selector">
                    Color del Precio Total:
                    <div class="color-circle" id="precio_selector"></div>
                    <input type="color" id="precio_color" name="precio_color" value="#000000" class="color-input" onchange="actualizarSelectorColor(this, 'precio_selector')">
                </label>
                <label for="fondo_color" class="color-selector">
                    Color de Fondo:
                    <div class="color-circle" id="fondo_selector"></div>
                    <input type="color" id="fondo_color" name="fondo_color" value="#f9f9f9" class="color-input" onchange="actualizarSelectorColor(this, 'fondo_selector')">
                </label>
            </div>
            <label for="tamano_fuente_codigo">Tamaño de Fuente del Código:</label>
            <input type="range" id="tamano_fuente_codigo" name="tamano_fuente_codigo" min="5" max="40" value="16" oninput="actualizarTamanioFuente('codigo', this.value)">
            <output for="tamano_fuente_codigo" id="tamano_fuente_codigo_output">16</output>
            <label for="tamano_fuente_total">Tamaño de Fuente del Total:</label>
            <input type="range" id="tamano_fuente_total" name="tamano_fuente_total" min="5" max="40" value="16" oninput="actualizarTamanioFuente('total', this.value)">
            <output for="tamano_fuente_total" id="tamano_fuente_total_output">16</output>
            <label for="tamano_codigo_barras">Tamaño del Código de Barras:</label>
            <input type="range" id="tamano_codigo_barras" name="tamano_codigo_barras" min="5" max="40" value="32" oninput="actualizarTamanoCodigoBarras(this.value)">
            <output for="tamano_codigo_barras" id="tamano_codigo_barras_output">32</output>
        </fieldset>
        <input type="submit" value="Generar Etiquetas" class="no-print">
    </form>

    <button class="no-print" onclick="imprimirEtiquetas()">Imprimir Etiquetas</button>
    <div class="header">
        <a href="http://localhost/consulta/administracion/index.php" class="back-button no-print">Volver</a>
    </div>

    <script src="https://cdn.jsdelivr.net/jsbarcode/3.11.0/JsBarcode.all.min.js"></script>
    <script>
        function imprimirEtiquetas() {
            document.querySelector(".no-print").style.display = "none";
            window.print();
            document.querySelector(".no-print").style.display = "block";
        }

        var anchoEtiquetaCmInput = document.getElementById("ancho_etiqueta_cm");
        var largoEtiquetaCmInput = document.getElementById("largo_etiqueta_cm");

        anchoEtiquetaCmInput.addEventListener("input", actualizarEtiquetas);
        largoEtiquetaCmInput.addEventListener("input", actualizarEtiquetas);

        var tamanoFuenteCodigoInput = document.getElementById("tamano_fuente_codigo");
        var tamanoFuenteTotalInput = document.getElementById("tamano_fuente_total");
        var tamanoCodigoBarrasInput = document.getElementById("tamano_codigo_barras");
        var tamanoFuenteCodigoOutput = document.getElementById("tamano_fuente_codigo_output");
        var tamanoFuenteTotalOutput = document.getElementById("tamano_fuente_total_output");
        var tamanoCodigoBarrasOutput = document.getElementById("tamano_codigo_barras_output");

        tamanoFuenteCodigoInput.addEventListener("input", function () {
            actualizarTamanioFuente('codigo', this.value);
            tamanoFuenteCodigoOutput.value = this.value;
        });

        tamanoFuenteTotalInput.addEventListener("input", function () {
            actualizarTamanioFuente('total', this.value);
            tamanoFuenteTotalOutput.value = this.value;
        });

        tamanoCodigoBarrasInput.addEventListener("input", function () {
            actualizarTamanoCodigoBarras(this.value);
            tamanoCodigoBarrasOutput.value = this.value;
        });

        var codigoColorInput = document.getElementById("codigo_color");
        var precioColorInput = document.getElementById("precio_color");
        var fondoColorInput = document.getElementById("fondo_color");

        codigoColorInput.addEventListener("input", actualizarColores);
        precioColorInput.addEventListener("input", actualizarColores);
        fondoColorInput.addEventListener("input", actualizarColores);

        function actualizarEtiquetas() {
            var anchoCm = parseFloat(anchoEtiquetaCmInput.value);
            var largoCm = parseFloat(largoEtiquetaCmInput.value);
            var anchoPx = anchoCm * 37.8;
            var largoPx = largoCm * 37.8;
            var tamanioFuenteCodigo = Math.min(anchoPx / 5, largoPx / 5);
            var tamanioFuenteTotal = Math.min(anchoPx / 5, largoPx / 5);

            var etiquetas = document.getElementsByClassName("etiqueta");
            for (var i = 0; i < etiquetas.length; i++) {
                etiquetas[i].style.width = anchoPx + "px";
                etiquetas[i].style.height = largoPx + "px";
                etiquetas[i].querySelector(".codigo").style.fontSize = tamanioFuenteCodigo + "px";
                etiquetas[i].querySelector(".total").style.fontSize = tamanioFuenteTotal + "px";
            }
        }

        function actualizarColores() {
            var codigoColor = codigoColorInput.value;
            var precioColor = precioColorInput.value;
            var fondoColor = fondoColorInput.value;

            var etiquetas = document.getElementsByClassName("etiqueta");
            for (var i = 0; i < etiquetas.length; i++) {
                etiquetas[i].querySelector(".codigo").style.color = codigoColor;
                etiquetas[i].querySelector(".total").style.color = precioColor;
                etiquetas[i].style.backgroundColor = fondoColor;
            }
        }

        function actualizarSelectorColor(inputColor, selectorId) {
            var color = inputColor.value;
            var selector = document.getElementById(selectorId);
            selector.style.backgroundColor = color;
        }

        function actualizarTamanioFuente(elemento, valor) {
            var tamanioFuente = valor + "px";
            var etiquetas = document.getElementsByClassName("etiqueta");
            for (var i = 0; i < etiquetas.length; i++) {
                if (elemento === 'codigo') {
                    etiquetas[i].querySelector(".codigo").style.fontSize = tamanioFuente;
                } else if (elemento === 'total') {
                    etiquetas[i].querySelector(".total").style.fontSize = tamanioFuente;
                }
            }
        }

        function actualizarTamanoCodigoBarras(valor) {
            var tamanioCodigoBarras = valor + "px";
            var codigoBarras = document.getElementsByClassName("codigo-barra");
            for (var i = 0; i < codigoBarras.length; i++) {
                codigoBarras[i].style.fontSize = tamanioCodigoBarras;
            }
        }
    </script>

    <?php
    $servername = "localhost";
    $username = "Francisco1234";
    $password = "1234";
    $dbname = "productos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $codigo = isset($_POST['codigo']) ? mysqli_real_escape_string($conn, $_POST['codigo']) : '';
        $cantidadEtiquetas = isset($_POST['cantidad_etiquetas']) ? intval($_POST['cantidad_etiquetas']) : 0;

        if ($cantidadEtiquetas <= 0) {
            echo "La cantidad de etiquetas debe ser un número positivo.";
        } else {
            $sql = "SELECT * FROM productos WHERE codigo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $codigo);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    for ($i = 0; $i < $cantidadEtiquetas; $i++) {
                        echo "<div class='etiqueta'>";
                        echo "<h2 class='codigo' style='font-size: 16px; font-family: \"arial\", sans-serif;'>Código: {$row['codigo']}</h2>";
                        echo "<p class='total' style='font-size: 16px;'>Precio Uni.: $ {$row['precio_total']}</p>";
                        echo "<p class='codigo-barra barcode' style='font-size: 32px; font-family: \"Bar-Code 39\", sans-serif;'>*{$row['codigo']}*</p>";

                        echo "<script>JsBarcode('.codigo-barra', '{$row['codigo']}', { format: 'CODE39' });</script>";

                        echo "</div>";
                    }
                }
            } else {
                echo "No se encontró ningún producto con ese código.";
            }
        }
    }

    $conn->close();
    ?>
</body>
</html>