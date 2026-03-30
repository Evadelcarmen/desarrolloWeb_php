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
    <title>Arreglos</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
<?php include("includes/header.php") ?>
<?php include("includes/menu.php") ?>

<div class="contenido">
    <h1><i class="bi bi-collection"></i>Arreglos en PHP</h1>
    <p>
        Un array en PHP es en realidad un mapa ordenado. Un mapa es un tipo que asocia valores a claves. Este tipo está optimizado para varios usos diferentes; puede ser tratado como un array, lista (vector), tabla hash (una implementación de un mapa), diccionario, colección, pila, cola, y probablemente más. 
    </p>
    <p>
        Existen 3 tipos principales de arreglos:
        <br>Indexados
        <br>Asociativos
        <br>Multidimensionales
    </p>

    <h2>Ejemplo de Arreglo Indexado</h2>
    <div class="ejemplo">
        <?php
        $frutas = ["Manzana", "Banana", "Naranja"];
        foreach ($frutas as $fruta) {
            echo "Fruta: $fruta <br>";
        }
        ?>
    </div>

    <button onclick="animarIndexado()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Animar ejemplo
    </button>

    <div id="resultado-indexado" class="ejemplo"></div>

    <h2>Ejemplo de Arreglo Asociativo</h2>
    <div class="ejemplo">
        <?php
        $persona = [
            "nombre" => "Eva",
            "edad" => 20,
            "ciudad" =>"Tuxtla"
        ];

        foreach($persona as $clave => $valor) {
            echo "$clave: $valor <br>";
        }
        ?>
    </div>

    <button onclick="animarAsociativo()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Animar ejemplo
    </button>

    <div id="resultado-asociativo" class="ejemplo"></div>

    <h2>Ejemplo de Arreglo Multidimensional</h2>
    <div class="ejemplo">
        <?php
        $alumnos = [
            ["nombre" => "Ana", "edad" => 20],
            ["nombre" => "Luis", "edad" => 22]
        ];
        foreach($alumnos as $alumno) {
            echo "Nombre: ". $alumno["nombre"] . "- Edad: " . $alumno["edad"] . "<br>";
        }
        ?>
    </div>

    <button onclick="animarMulti()" class="btn-animar">
        <i class="bi bi-play-fill"></i> Animar ejemplo
    </button>

    <div id="resultado-multi" class="ejemplo"></div>
</div>

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

    function animarIndexado() {
        let cont = document.getElementById("resultado-indexado");
        cont.innerHTML = "";
        limpiarAnimacion("indexado");

        let frutas = ["Manzana", "Banana", "Naranja"];
        let i = 0;

        animaciones["indexado"] = setInterval(() => {
            cont.innerHTML += "Indice [" + i + "] => " + frutas[i] + "<br>";
            i++;
            if (i >= frutas.length) {
                clearInterval(animaciones["indexado"]);
            }
        }, 600);
    }

    function animarAsociativo() {
        let cont = document.getElementById("resultado-asociativo");
        cont.innerHTML = "";
        limpiarAnimacion("asociativo");

        let persona = {nombre:"Eva", edad:20, ciudad: "Tuxtla"};
        let claves = Object.keys(persona);
        let i = 0;

        animaciones["asociativo"] = setInterval(() => {
            let clave = claves[i];
            cont.innerHTML += clave + " => " + persona[clave] + "<br>";
            i++;
            if (i >= claves.length) {
                clearInterval(animaciones["asociativo"]);
            }
        }, 600);
    }

    function animarMulti() {
        let cont = document.getElementById("resultado-multi");
        cont.innerHTML = "";
        limpiarAnimacion("multi");

        let alumnos = [
            {nombre: "Ana", edad: 20},
            {nombre: "Luis", edad: 22}
        ];

        let i = 0;

        animaciones["multi"] = setInterval(() => {
            cont.innerHTML += "Alumno: " + alumnos[i].nombre + " -Edad: " + alumnos[i].edad + "<br>";
            i++;
            if (i >= alumnos.length) {
                clearInterval(animaciones["multi"]);
            }
        }, 600);
    }
</script>

<?php include("includes/footer.php");?>
</body>
</html>
