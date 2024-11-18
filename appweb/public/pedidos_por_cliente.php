<?php
session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Tus pedidos";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_clientes.html';

    ?>

    <main>

        <div class="text-secondary text-center m-4 ">
            <h2>Tus pedidos</h2>
        </div>

        <table class="table table-striped">
            <tr>
                <th class="text-center"style="color: white">Horario</th>
                <th class="text-center"style="color: white">Nombre</th>
                <th class="text-center"style="color: white">Dia</th>
                <th class="text-center"style="color: white">Costo</th>
            </tr>
            <?php
            include '../resources/db/ReservacionDB.php';
            $reservacioDB = new ReservacionDB();
            $pedidos = $reservacioDB->getReservacionPorUsuario($_SESSION['id_usuario']);
            foreach ($pedidos as $pedido):?>

                <tr>
                    <td class="text-center"style="background: brown"><?= $pedido['horario'] ?></td>
                    <td class="text-center"style="background: dimgray"><?= $pedido['nombre'] ?></td>
                    <td class="text-center"style="background: brown"><?= $pedido['dia'] ?></td>
                    <td class="text-center"style="background: dimgray"><?= $pedido['importe'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </main>

    <?php

    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}
