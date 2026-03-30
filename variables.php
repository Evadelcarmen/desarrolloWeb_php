<?php
session_start();

// protege la pagina
if(!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

// asegura tiempo
if (!isset($_SESSION["tiempo_inicio"])) {
    $_SESSION["tiempo_inicio"] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Variables</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

<?php include("includes/header.php") ?>
<?php include("includes/menu.php") ?>

<div class="contenido">
    <h1><i class="bi bi-code-square"></i>Variables en PHP</h1>

    <p>
        Las variables en PHP se utilizan para almacenar información que puede cambiar durante la ejecución del programa. 
        Se definen utilizando el símbolo <b>$</b> seguido del nombre de la variable.
    </p>

    <p>
        PHP permite trabajar con diferentes tipos de datos como cadenas de texto, números, valores booleanos y arreglos.
        Estas variables pueden ser utilizadas en operaciones, estructuras de control y funciones.
    </p>

    <h2>Ejemplo básico de variables</h2>
    <div class="ejemplo">
        <?php
        $nombre = "Yazmin";
        $edad = 20;

        echo "Nombre: $nombre <br>";
        echo "Edad: $edad <br>";
        ?>
    </div>

    <h2>Tipos de datos en PHP</h2>
    <div class="ejemplo">
        <?php
        $texto = "Hola mundo";       // string
        $numero = 25;               // int
        $decimal = 10.5;            // float
        $activo = true;             // boolean
        $colores = ["Rojo","Azul"]; // array

        echo "Texto: $texto <br>";
        echo "Número entero: $numero <br>";
        echo "Número decimal: $decimal <br>";
        echo "Valor booleano: $activo <br>";
        echo "Cantidad de elementos en el arreglo: " . count($colores) . "<br>";
        echo "Hora actual del sistema: " . date("H:i:s") . "<br>";
        ?>
    </div>

    <h2>Uso de funciones con variables</h2>
    <div class="ejemplo">
        <?php
        $numeros = [10, 20, 30, 40];

        echo "Total de elementos: " . count($numeros) . "<br>";

        echo "Hora actual usando date(): " . date("H:i:s") . "<br>";
        ?>
    </div>

    <button onclick="animarVariables()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Ejecutar Animación
    </button>

    <div id="resultado-var" class="ejemplo"></div>
</div>

<?php
// tiempo sesión
$tiempo_maximo = 60;

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

$tiempoActivo = time() - $_SESSION["tiempo_inicio"];
?>

<script>
let tiempo = <?php echo $tiempoActivo; ?>;
let maximo = <?php echo $tiempo_maximo; ?>;

let intervalo = setInterval(actualizarTiempo, 1000);

function actualizarTiempo() {
    let restante = maximo - tiempo;

    if (document.getElementById("restante")) {
        document.getElementById("restante").innerText = restante;
    }

    let minutos = Math.floor(tiempo / 60);
    let segundos = tiempo % 60;

    if (document.getElementById("tiempoActivoTexto")) {
        document.getElementById("tiempoActivoTexto").innerText = minutos + " min " + segundos + " seg";
    }

    let ahora = new Date();
    let h = String(ahora.getHours()).padStart(2,'0');
    let m = String(ahora.getMinutes()).padStart(2,'0');
    let s = String(ahora.getSeconds()).padStart(2,'0');

    if (document.getElementById("horaActualTexto")) {
        document.getElementById("horaActualTexto").innerText = h + ":" + m + ":" + s;
    }

    tiempo++;

    if (tiempo > maximo) {
        clearInterval(intervalo);
        window.location.href = "index.php?expirado=true";
    }
}

// animaciones (igual estilo que tu amiga)
let animaciones = {};

function limpiarAnimacion(nombre) {
    if(animaciones[nombre]) {
        clearInterval(animaciones[nombre]);
    }
}

function animarVariables() {
    let cont = document.getElementById("resultado-var");
    cont.innerHTML = "";
    limpiarAnimacion("var");

    let datos = [
        "$nombre = Yazmin",
        "$edad = 20",
        "$texto = Hola mundo",
        "$numero = 25",
        "$decimal = 10.5",
        "$activo = true",
        "count(colores) = 2",
        "date() = hora actual"
    ];

    let i = 0;

    animaciones["var"] = setInterval(() => {
        cont.innerHTML += "<span>Variable: " + datos[i] + "</span><br>";
        i++;
        if(i >= datos.length){
            clearInterval(animaciones["var"]);
            cont.innerHTML += "<br><em>✔ Variables ejecutadas correctamente</em>";
        }
    }, 600);
}

// sidebar
function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const body = document.body;

    sidebar.classList.toggle("active");
    body.classList.toggle("shift");
}
</script>

<?php include("includes/footer.php");?>
</body>
</html>

