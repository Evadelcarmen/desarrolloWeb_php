<?php
session_start();
//protege la pagina
if(!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucles</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
<?php include("includes/header.php") ?>
<?php include("includes/menu.php") ?>

<div class="contenido">
    <h1><i class="bi bi-arrow-repeat"></i>Bucles en PHP</h1>
    <p>
        Los bucles en PHP son estructuras de control fundamentales en la programación que ejecutan repetidamente un bloque de código según una condición específica . Esta condición se evalúa antes o después de cada iteración, dependiendo del tipo de bucle utilizado. Mientras la condición sea verdadera, el bucle continúa ejecutándose. Una vez que la condición se vuelve falsa, el programa sale del bucle y continúa con el resto de la ejecución.
    </p>
    <p>
        PHP cuenta con varios tipos de bucles, como `for` , `while` , `do while` y `for each` . 
    </p>

    <h2>Ejemplo For</h2>
    <div class="ejemplo">
        <?php
        for($i=1; $i <=5; $i++) {
            echo "Numero: $i <br>";
        }
        ?>
    </div>
    <button onclick="animarFor()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Ejecutar Animación For
    </button>
    <div id="resultado-for" class="ejemplo"></div>
    <h2>Ejemplo While</h2>
    <div class="ejemplo">
        <?php
        $i=1;
        while ($i <= 5) {
            echo "Contador: $i <br>";
            $i++;
        }
        ?>
    </div>
    <button onclick="animarWhile()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Ejecutar Animación While
    </button>
    <div id="resultado-while" class="ejemplo"></div>
    <h2>Ejemplo Do-While</h2>
    <div class="ejemplo">
        <?php
        $i=1;
        do {
            echo "Valor: $i <br>";
            $i++;
        } while ($i <= 5);
        ?>
    </div>
    <button onclick="animarDoWhile()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Ejecutar Animación Do-While
    </button>
    <div id="resultado-dowhile" class="ejemplo"></div>
    <h2>Ejemplo foreach</h2>
    <div class="ejemplo">
        <?php
        $colores = ["Rojo", "Azul", "Verde"];
        foreach ($colores as $color) {
            echo "Color: $color <br>";
        }
        ?>
    </div>
    <button onclick="animarForEach()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Ejecutar Animación ForEach
    </button>
    <div id="resultado-foreach" class="ejemplo"></div>

<?php
// Tiempo máximo de sesión
$tiempo_maximo = 60;

// Verifica si la sesión expiró
if (isset($_SESSION["tiempo_inicio"])) {
    $tiempo_actual = time();
    $tiempo_transcurrido = $tiempo_actual - $_SESSION["tiempo_inicio"];

    if ($tiempo_transcurrido > $tiempo_maximo) {
        session_unset();
        session_destroy();
        header("Location: index.php?expirado=true");
        exit();
    }
}

$tiempoActivo = 0;
if (isset($_SESSION["tiempo_inicio"])) {
    $tiempoActivo = time() - $_SESSION["tiempo_inicio"];
}
?>
</div>
<!-- SCRIPT PARA LA CUENTA REGRESIVA Y SIDEBAR -->
<script>
    let tiempo = <?php echo $tiempoActivo; ?>;
    let maximo = <?php echo $tiempo_maximo; ?>;

    let intervalo = setInterval(actualizarTiempo, 1000);

    function actualizarTiempo() {
        let restante = maximo - tiempo;

        if (document.getElementById("restante")) {
            document.getElementById("restante").innerText = restante;
        }

        // Mostrar tiempo activo en minutos y segundos
        let minutos = Math.floor(tiempo / 60);
        let segundos = tiempo % 60;
        let texto = minutos + " min " + segundos + " seg";

        if (document.getElementById("tiempoActivoTexto")) {
            document.getElementById("tiempoActivoTexto").innerText = texto;
        }

        // Mostrar hora actual dinámica
        let ahora = new Date();
        let horas = String(ahora.getHours()).padStart(2, '0');
        let mins = String(ahora.getMinutes()).padStart(2, '0');
        let segs = String(ahora.getSeconds()).padStart(2, '0');
        if (document.getElementById("horaActualTexto")) {
            document.getElementById("horaActualTexto").innerText = horas + ":" + mins + ":" + segs;
        }

        tiempo++;

        if (tiempo > maximo) {
            clearInterval(intervalo);
            window.location.href = "index.php?expirado=true";
        }
    }

    actualizarTiempo();

    function toggleSidebar() {
        const sidebar = document.querySelector(".sidebar");
        const body = document.body;

        sidebar.classList.toggle("active");
        body.classList.toggle("shift");
    }
    // guarda las animaciones
    let animaciones = {};

    // funcion para limipiar una animacion previa
    function limpiarAnimacion(nombre) {
        if (animaciones[nombre]) {
            clearInterval(animaciones[nombre]);
        }
    }

    //ANIMACIÓN FOR
    function animarFor() {
        let contenedor = document.getElementById("resultado-for");
        contenedor.innerHTML = "";
        limpiarAnimacion("for");

        let i = 1;
        animaciones["for"] = setInterval(() => {
            contenedor.innerHTML += "<span>Iteración " + i + ": Numero = " + i + "</span><br>";
            i++;
            if (i > 5) {
                clearInterval(animaciones["for"]);
                contenedor.innerHTML += "<br><em>✔ Bucle for finalizado</em>";
            }
        }, 600);
    }

    //ANIMACIÓN WHILE
    function animarWhile() {
        let contenedor = document.getElementById("resultado-while");
        contenedor.innerHTML = "";
        limpiarAnimacion("while");

        let i = 1;
        animaciones["while"] = setInterval(() => {
            contenedor.innerHTML += "<span>Mientras i(" + i + ") <= 5 → Contador: " + i + "</span><br>";
            i++;
            if (i > 5) {
                clearInterval(animaciones["while"]);
                contenedor.innerHTML += "<br><em>✔ Condición falsa (i=" + i + "), bucle while finalizado</em>";
            }
        }, 600);
    }

    //ANIMACIÓN DO-WHILE
    function animarDoWhile() {
        let contenedor = document.getElementById("resultado-dowhile");
        contenedor.innerHTML = "";
        limpiarAnimacion("dowhile");

        let i = 1;
        animaciones["dowhile"] = setInterval(() => {
            contenedor.innerHTML += "<span>Ejecuta primero → Valor: " + i + " (luego verifica i <= 5)</span><br>";
            i++;
            if (i > 5) {
                clearInterval(animaciones["dowhile"]);
                contenedor.innerHTML += "<br><em>✔ Condición falsa (i=" + i + "), bucle do-while finalizado</em>";
            }
        }, 600);
    }

    //ANIMACIÓN FOREACH
    function animarForEach() {
        let contenedor = document.getElementById("resultado-foreach");
        contenedor.innerHTML = "";
        limpiarAnimacion("foreach");

        let colores = ["Rojo", "Azul", "Verde", "Amarillo", "Naranja"];
        let index = 0;
        animaciones["foreach"] = setInterval(() => {
            contenedor.innerHTML += "<span>Elemento [" + index + "] → Color: " + colores[index] + "</span><br>";
            index++;
            if (index >= colores.length) {
                clearInterval(animaciones["foreach"]);
                contenedor.innerHTML += "<br><em>✔ No hay más elementos, bucle foreach finalizado</em>";
            }
        }, 600);
    }
</script>

<?php include("includes/footer.php");?>
</body>
</html>