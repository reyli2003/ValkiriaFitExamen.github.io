<?php
session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Confirmación";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_clientes.html';
    ?>

    <main>

        <div class="text-secondary text-center m-5">
            <h2> Gracias <?php print $_SESSION['usuario'] ?> </h2>
            <h2 class="mt-5">En breve el pedido será validado, posteriormente se mandará información del envio por correo electrónico</h2>
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
