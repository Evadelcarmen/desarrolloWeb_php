<?php
session_start();

if (isset($_GET["expirado"])) {
    session_unset();
    session_destroy();
    $_SESSION = [];
    unset($_SESSION["usuario"]);
}

// se asigna el tiempo maximo de sesion para el usuario
$tiempo_maximo = 60;

//Cerrar sesión manual
if (isset($_GET["logout"])) {
    session_unset();
    session_destroy();
    header("Location: ?");
    exit();
}

// se verifica cuando se expira la sesion
if (isset($_SESSION["tiempo_inicio"])) {
    $tiempo_actual = time();
    $tiempo_transcurrido = $tiempo_actual - $_SESSION["tiempo_inicio"];

    if ($tiempo_transcurrido > $tiempo_maximo) {
        session_unset();
        session_destroy();
        header("Location: ?expirado=true");
        exit();
    }
}

// iniciar sesión (sin login)
if (isset($_GET["iniciar"])) {
    $_SESSION["usuario"] = "Invitado";
    $_SESSION["tiempo_inicio"] = time();
}

// einiciar sesión
if (isset($_GET["reiniciar"])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// extra
$tiempoActivo = 0;
if (isset($_SESSION["tiempo_inicio"])) {
    $tiempoActivo = time() - $_SESSION["tiempo_inicio"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi sitio web</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>

<?php include("includes/header.php"); ?>
<?php include("includes/menu.php"); ?>

<div class="contenido">
<?php if (!isset($_SESSION["usuario"])) { ?>

    <h1>Inicia Sesión</h1>

    <a href="?iniciar=true" class="btn-animar">
        Iniciar sesión
    </a>

<?php } else { ?>

    <h1>Bienvenido, <?php echo $_SESSION["usuario"]; ?></h1>
    <br>
    <a href="?reiniciar=true" class="logout">
        Reiniciar sesión
    </a>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>

<script>
    let tiempo = <?php echo $tiempoActivo; ?>;
    let maximo = <?php echo $tiempo_maximo; ?>;

    let intervalo = setInterval(actualizarTiempo, 1000);

    function actualizarTiempo() {

        // Mostrar tiempo restante (si usas contador)
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

        // Expirar sesión
        if (tiempo > maximo) {
            clearInterval(intervalo);
            window.location.href = "?expirado=true";
        }
    }

    // Ejecutar inmediato
    actualizarTiempo();

    // Toggle del sidebar
    function toggleSidebar() {
        const sidebar = document.querySelector(".sidebar");
        const body = document.body;

        sidebar.classList.toggle("active");
        body.classList.toggle("shift");
    }
</script>

</body>
</html>