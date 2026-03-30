<?php
session_start();

if(!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION["tiempo_inicio"])) {
    $_SESSION["tiempo_inicio"] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Condicionales</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

<?php include("includes/header.php") ?>
<?php include("includes/menu.php") ?>

<div class="contenido">
    <h1><i class="bi bi-question-circle"></i>Condicionales en PHP</h1>

    <p>
        Las estructuras condicionales permiten tomar decisiones dentro de un programa dependiendo de si una condición es verdadera o falsa.
    </p>

    <p>
        En PHP se utilizan estructuras como <b>if</b>, <b>else</b>, <b>elseif</b> y <b>switch</b> para controlar el flujo del programa.
    </p>

    <h2>Ejemplo If - Else</h2>
    <div class="ejemplo">
        <?php
        $edad = 18;

        if($edad >= 18){
            echo "Eres mayor de edad <br>";
        } else {
            echo "Eres menor de edad <br>";
        }
        ?>
    </div>

    <h2>Ejemplo If - Elseif - Else</h2>
    <div class="ejemplo">
        <?php
        $calificacion = 85;

        if($calificacion >= 90){
            echo "Excelente <br>";
        } elseif($calificacion >= 70){
            echo "Aprobado <br>";
        } else {
            echo "Reprobado <br>";
        }
        ?>
    </div>

    <h2>Ejemplo Switch</h2>
    <div class="ejemplo">
        <?php
        $dia = 3;

        switch($dia){
            case 1:
                echo "Lunes <br>";
                break;
            case 2:
                echo "Martes <br>";
                break;
            case 3:
                echo "Miércoles <br>";
                break;
            default:
                echo "Otro día <br>";
        }
        ?>
    </div>

    <button onclick="animarCondicional()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Ejecutar Animación
    </button>

    <div id="resultado-cond" class="ejemplo"></div>
</div>

<?php
// control de tiempo de sesión
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

function limpiarAnimacion(n){
    if(animaciones[n]) clearInterval(animaciones[n]);
}

function animarCondicional(){
    let cont = document.getElementById("resultado-cond");
    cont.innerHTML = "";
    limpiarAnimacion("cond");

    let pasos = [
        "Edad = 18",
        "Evaluando condición: edad >= 18",
        "✔ Verdadero → Mayor de edad",
        "Calificación = 85",
        "Evaluando: >= 70 → Aprobado",
        "Switch día = 3",
        "Resultado → Miércoles"
    ];

    let i = 0;

    animaciones["cond"] = setInterval(()=>{
        cont.innerHTML += "<span>" + pasos[i] + "</span><br>";
        i++;
        if(i >= pasos.length){
            clearInterval(animaciones["cond"]);
            cont.innerHTML += "<br><em>✔ Condicionales ejecutados correctamente</em>";
        }
    },600);
}

function toggleSidebar(){
    document.querySelector(".sidebar").classList.toggle("active");
    document.body.classList.toggle("shift");
}
</script>

<?php include("includes/footer.php");?>
</body>
</html>
