<?php if (isset($_SESSION["usuario"]))  { ?>
<nav class="sidebar">
    <ul class="sidebar-list">
        <li><a href="#">Variables</a></li>
        <li><a href="#">Condicionales</a></li>
        <li><a href="bucles.php"><i class="bi bi-arrow-repeat"></i>Bucles</a></li>
        <li><a href="arreglos.php"><i class="bi bi-collection"></i>Arreglos</a></li>

        <li class="logout-item">
            <a href="?logout=true"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
        </li>
    </ul>
</nav>
<?php } ?>
