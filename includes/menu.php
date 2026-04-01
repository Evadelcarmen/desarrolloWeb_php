<?php if (isset($_SESSION["usuario"]))  { ?>
<nav class="sidebar">
    <ul class="sidebar-list">
        <li><a href="index.php"><i class="bi bi-house-door-fill"></i>Inicio</a></li>
        <li><a href="variables.php"><i class="bi bi-code-square"></i>Variables</a></li>
        <li><a href="condicionales.php"><i class="bi bi-question-circle"></i>Condicionales</a></li>
        <li><a href="bucles.php"><i class="bi bi-arrow-repeat"></i>Bucles</a></li>
        <li><a href="arreglos.php"><i class="bi bi-collection"></i>Arreglos</a></li>
        <li><a href="sesiones.php"><i class="bi bi-person"></i>Sesiones</a></li>

        <li class="logout-item">
            <a href="?logout=true"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
        </li>
    </ul>
</nav>
<?php } ?>
