<?php
session_start();

// protege la pagina
if(!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

// asegurar tiempo inicial
if (!isset($_SESSION["tiempo_inicio"])) {
    $_SESSION["tiempo_inicio"] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sesiones</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

<?php include("includes/header.php") ?>
<?php include("includes/menu.php") ?>

<div class="contenido">
    <h1><i class="bi bi-person"></i>Sesiones en PHP</h1>

    <p>
        Las sesiones en PHP permiten almacenar información del usuario de manera temporal mientras navega en diferentes páginas del sitio web.
    </p>

    <p>
        Se utilizan para mantener datos como el usuario activo, la hora de inicio de sesión y el tiempo que lleva dentro del sistema.
    </p>

    <h2>Ejemplo de sesión</h2>
    <div class="ejemplo">
        <?php
        echo "Usuario: " . $_SESSION["usuario"] . "<br>";
        echo "Hora de inicio: " . date("H:i:s", $_SESSION["tiempo_inicio"]) . "<br>";
        ?>
    </div>

    <h2>Tiempo activo del usuario</h2>
    <div class="ejemplo">
        <p>Hora actual: <span id="horaActualTexto"></span></p>
        <p>Tiempo activo: <span id="tiempoActivoTexto"></span></p>
    </div>

    <button onclick="animarSesion()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Ejecutar Animación
    </button>

    <div id="resultado-sesion" class="ejemplo"></div>
</div>

<?php
// tiempo máximo de sesión
$tiempo_maximo = 60;

// verificar expiración
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

// calcular tiempo activo
$tiempoActivo = time() - $_SESSION["tiempo_inicio"];
?>

<!-- SCRIPT IGUAL QUE TU AMIGA -->
<script>
let tiempo = <?php echo $tiempoActivo; ?>;
let maximo = <?php echo $tiempo_maximo; ?>;

let intervalo = setInterval(actualizarTiempo, 1000);

function actualizarTiempo() {

    // mostrar tiempo restante
    let restante = maximo - tiempo;
    if (document.getElementById("restante")) {
        document.getElementById("restante").innerText = restante;
    }

    // convertir a minutos y segundos
    let minutos = Math.floor(tiempo / 60);
    let segundos = tiempo % 60;

    let texto = minutos + " min " + segundos + " seg";

    if (document.getElementById("tiempoActivoTexto")) {
        document.getElementById("tiempoActivoTexto").innerText = texto;
    }

    // hora actual dinámica
    let ahora = new Date();
    let h = String(ahora.getHours()).padStart(2,'0');
    let m = String(ahora.getMinutes()).padStart(2,'0');
    let s = String(ahora.getSeconds()).padStart(2,'0');

    if (document.getElementById("horaActualTexto")) {
        document.getElementById("horaActualTexto").innerText = h + ":" + m + ":" + s;
    }

    tiempo++;

    // expira sesión automáticamente
    if (tiempo > maximo) {
        clearInterval(intervalo);
        window.location.href = "index.php?expirado=true";
    }
}

// ejecutar inmediatamente
actualizarTiempo();

// animaciones
let animaciones = {};

function limpiarAnimacion(n){
    if(animaciones[n]) clearInterval(animaciones[n]);
}

function animarSesion(){
    let cont = document.getElementById("resultado-sesion");
    cont.innerHTML = "";
    limpiarAnimacion("sesion");

    let pasos = [
        "Se inicia la sesión con session_start()",
        "Se guarda el usuario en $_SESSION",
        "Se guarda la hora inicial con time()",
        "Se calcula el tiempo activo",
        "✔ Sesión activa funcionando correctamente"
    ];

    let i = 0;

    animaciones["sesion"] = setInterval(()=>{
        cont.innerHTML += "<span>" + pasos[i] + "</span><br>";
        i++;
        if(i >= pasos.length){
            clearInterval(animaciones["sesion"]);
            cont.innerHTML += "<br><em>✔ Sesión demostrada correctamente</em>";
        }
    },600);
}

// sidebar
function toggleSidebar(){
    const sidebar = document.querySelector(".sidebar");
    const body = document.body;

    sidebar.classList.toggle("active");
    body.classList.toggle("shift");
}
</script>

<?php include("includes/footer.php");?>
</body>
</html>
