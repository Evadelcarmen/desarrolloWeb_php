<header class="header">
    <div class="header-container">
        <h1 class="logo">
            <i class="bi bi-pc-display"></i> Mi sistema PHP
        </h1>

        <?php if (isset($_SESSION["usuario"])) {?>
        <div class="header-right">
            <p class="user-info">
                    Usuario: <strong><?php echo $_SESSION["usuario"]; ?></strong>
            </p>
            <div class="contador-box">
                <p>Restante: <span id="restante"></span></p>
            </div>
        </div>
        <?php } ?>
    </div>
</header>