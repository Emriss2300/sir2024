<?php
// Conexión a la base de datos
require_once 'conexion.php';

// Ruta completa de la carpeta de imágenes
$carpetaImagenes = 'C:/xampp/htdocs/consulta/administracion/codigos de barra/';

// Obtener la lista de archivos en la carpeta de imágenes
$archivos = scandir($carpetaImagenes);

// Recorrer la lista de archivos
foreach ($archivos as $archivo) {
    // Ignorar los directorios y los archivos ocultos
    if (is_file($carpetaImagenes . $archivo) && $archivo[0] != '.') {
        // Supongamos que el nombre del archivo coincide con el código de producto
        $codigoProducto = pathinfo($archivo, PATHINFO_FILENAME);

        // Construir la URL completa de la imagen
        $urlImagen = $carpetaImagenes . $archivo;

        // Actualizar la base de datos con la URL de la imagen
        $sql = "UPDATE productos SET codigo_barra = '$urlImagen' WHERE codigo = '$codigoProducto'";

        if ($conn->query($sql) === TRUE) {
            echo "Se actualizó el código de barras para el producto $codigoProducto.<br>";
        } else {
            echo "Error al actualizar el código de barras para el producto $codigoProducto: " . $conn->error . "<br>";
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
