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
//declaracion de usuari y contraseñas simulados
$usuarioCorrecto = "admin";
$passwordCorrecto = "1234";

// se procesa el inicio de sesion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    if ($usuario == $usuarioCorrecto && $password == $passwordCorrecto) {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["tiempo_inicio"] = time();
        // Redirigir para evitar reenvío del formulario (Post-Redirect-Get)
        header("Location: index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
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

<?php if (isset($_SESSION["usuario"])) { ?>
    <h1>Bienvenido, <?php echo $_SESSION["usuario"]; ?></h1>
<?php } else { ?>    
    <h1>Inicia Sesión</h1>
<?php } ?>

<?php if (isset($_GET["expirado"])) { ?>
    <p style="color:red;">Tu sesión ha expirado</p>
<?php } ?>

<?php if (!isset($_SESSION["usuario"])) { ?>

    <!-- SE CREA EL FORMULARIO -->
    <form method="post" class="form-login">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Iniciar sesión</button>
    </form>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<?php } else { ?>

    <!-- SCRIPT PARA LA CUENTA REGRESIVA-->
    <script>
        let tiempo = <?php echo $tiempoActivo; ?>;
        let maximo = <?php echo $tiempo_maximo; ?>;

        let intervalo = setInterval(actualizarTiempo, 1000);
        actualizarTiempo(); // Mostrar el valor inmediatamente

        function actualizarTiempo() {
            let restante = maximo - tiempo;

            if (document.getElementById("restante")) {
                document.getElementById("restante").innerText = restante;
            }

            tiempo++;

            // CUANDO YA PASO EL TIEMPO, SE HACE UN CIERRE DEFINITIVO
            if (tiempo > maximo) {
                clearInterval(intervalo);
                //alert("Sesión expirada");
                window.location.href = "?expirado=true";
            }
        }
        function toggleSidebar() {
            const sidebar = document.querySelector(".sidebar");
            const body = document.body;

            sidebar.classList.toggle("active");
            body.classList.toggle("shift");
        }
    </script>

<?php } ?>

<?php include("includes/footer.php"); ?>

</body>
</html>