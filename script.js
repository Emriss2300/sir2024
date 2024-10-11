function actualizarEtiquetas() {
    // Obtener los elementos de entrada para el ancho y el largo en centímetros
    var anchoEtiquetaCmInput = document.getElementById("ancho_etiqueta_cm");
    var largoEtiquetaCmInput = document.getElementById("largo_etiqueta_cm");

    // Agregar eventos de cambio a los elementos de entrada de ancho y largo en centímetros
    anchoEtiquetaCmInput.addEventListener("input", function () {
        actualizarTamañoEtiquetas();
    });

    largoEtiquetaCmInput.addEventListener("input", function () {
        actualizarTamañoEtiquetas();
    });

    // Obtener los elementos de selección de color
    var codigoColorInput = document.getElementById("codigo_color");
    var precioColorInput = document.getElementById("precio_color");
    var fondoColorInput = document.getElementById("fondo_color");

    // Agregar eventos de cambio a los elementos de selección de color
    codigoColorInput.addEventListener("input", function () {
        actualizarColores();
    });

    precioColorInput.addEventListener("input", function () {
        actualizarColores();
    });

    fondoColorInput.addEventListener("input", function () {
        actualizarColores();
    });

    // Función para actualizar el tamaño del texto dentro de las etiquetas en tiempo real
    function actualizarTamañoEtiquetas() {
        // Obtener el valor seleccionado de ancho y largo en centímetros
        var anchoCm = parseFloat(anchoEtiquetaCmInput.value);
        var largoCm = parseFloat(largoEtiquetaCmInput.value);

        // Calcular el valor en píxeles (asumiendo 1 cm = 37.8 px, puedes ajustarlo según tu preferencia)
        var anchoPx = anchoCm * 37.8;
        var largoPx = largoCm * 37.8;

        // Calcular el tamaño de fuente en función del ancho y el largo
        var tamanioFuente = Math.min(anchoPx / 5, largoPx / 5); // Puedes ajustar el factor (5) según tu preferencia

        // Aplicar el tamaño de fuente en píxeles en tiempo real
        var etiquetas = document.getElementsByClassName("etiqueta");
        for (var i = 0; i < etiquetas.length; i++) {
            etiquetas[i].style.width = anchoPx + "px";
            etiquetas[i].style.height = largoPx + "px";
            etiquetas[i].style.fontSize = tamanioFuente + "px";
        }
    }

    // Función para actualizar los colores en tiempo real
    function actualizarColores() {
        var codigoColor = codigoColorInput.value;
        var precioColor = precioColorInput.value;
        var fondoColor = fondoColorInput.value;

        // Aplicar los colores a las etiquetas en tiempo real
        var etiquetas = document.getElementsByClassName("etiqueta");
        for (var i = 0; i < etiquetas.length; i++) {
            etiquetas[i].querySelector("h2").style.color = codigoColor;
            etiquetas[i].querySelector("p").style.color = precioColor;
            etiquetas[i].style.backgroundColor = fondoColor;
        }
    }

    // Llamar a las funciones de actualización al cargar la página
    actualizarTamañoEtiquetas();
    actualizarColores();
}

document.addEventListener("DOMContentLoaded", function () {
    actualizarEtiquetas();
});
