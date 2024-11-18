<?php
session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Cliente";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_clientes.html';
    ?>

    <main>

            <div class="text-center">
            <h2 class="text-warning m-5">Hola <?= $_SESSION['usuario'] ?></h2>
        </div>

    </main>

    <?php

    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}