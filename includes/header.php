<header class="header">
    <div class="header-container">

        <div class="header-left">
            <?php if (isset($_SESSION["usuario"])) { ?>
                <i class="bi bi-layout-sidebar sidebar-toggle" onclick="toggleSidebar()"></i>
            <?php } ?>

            <h1 class="logo">
                <a href="/desarrolloWeb_php/index.php">
                    <i class="bi bi-pc-display"></i> Mi sistema PHP
                </a>
            </h1>
        </div>

        <?php if (isset($_SESSION["usuario"])) {?>
        <div class="header-right">

            <p class="user-info">
                Usuario:
                <strong>
                    <?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "Invitado"; ?>
                </strong>
            </p>

            <div class="contador-box">
                <i class="bi bi-clock-history"></i>
                <p>Hora inicio</p>
                <span>
                    <?php 
                    if (isset($_SESSION["tiempo_inicio"])) {
                        echo date("H:i:s", $_SESSION["tiempo_inicio"]);
                    } else {
                        echo "--:--:--";
                    }
                    ?>
                </span>
            </div>

            <div class="contador-box">
                <i class="bi bi-clock"></i>
                <p>Hora actual</p>
                <span id="horaActualTexto"><?php echo date("H:i:s"); ?></span>
            </div>

            <div class="contador-box">
                <i class="bi bi-hourglass-split"></i>
                <p>Tiempo activo</p>
                <span id="tiempoActivoTexto">0s</span>
            </div>

        </div>
        <?php } ?>
    </div>
</header>