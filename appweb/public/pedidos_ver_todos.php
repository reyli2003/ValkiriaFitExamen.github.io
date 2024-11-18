<?php
session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Pedidos";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_administrador.html';

//    include '../resources/DB/PedidoDB.php';
//    $pedidoDB = new PedidoDB();
//    $pedidos = $pedidoDB->getPedidos();
    ?>

    <main>

        <div class="text-secondary text-center m-4 ">
            <h2>Tabla de pedidos</h2>
        </div>

        <input class="form-control mb-5" type="text" id="busqueda" onkeyup="funcionBuscar()"
               placeholder="Búsqueda por usuario" title="Escribe un usuario">

        <table class="table table-striped" id="tabla">
            <tr>
                <th class="text-center"style="color: white">Usuario</th>
                <th class="text-center"style="color: white">Hora</th>
                <th class="text-center"style="color: white">Nombre</th>
                <th class="text-center"style="color: white">Dia</th>
                <th class="text-center"style="color: white">Capacidad</th>
                <th class="text-center"style="color: white">Costo</th>

            </tr>
            <?php
            include '../resources/db/ReservacionDB.php';
            $reservacionDB = new ReservacionDB();
            $reservaciones = $reservacionDB->getReservacion();
            foreach ($reservaciones as $reservacion):?>
                <tr>
                    <td class="text-center"style="background: brown"><?= $reservacion['usuario'] ?></td>
                    <td class="text-center"style="background: dimgray"><?= $reservacion['horario'] ?></td>
                    <td class="text-center"style="background: brown"><?= $reservacion['nombre'] ?></td>
                    <td class="text-center"style="background: dimgray"><?= $reservacion['dia'] ?></td>
                    <td class="text-center"style="background: brown"><?= $reservacion['capacidad'] ?></td>
                    <td class="text-center"style="background: dimgray"><?= $reservacion['importe'] ?></td>
                </tr>
                <td class="text-center">
                    <!-- Formulario para eliminar -->
                    <form action="eliminar_pedido.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este pedido?');">
                        <input type="hidden" name="id_reservacion" id="id_reservacion" value="<?= $reservacion['id_reservacion'] ?>"> <!-- Enviar el ID del pedido -->
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            <?php endforeach; ?>
        </table>
    </main>

    <?php

    include '../resources/templates/footer.html';
    ?>
    <script>
        function funcionBuscar() {
            let textoBuscar, tabla, renglones, primerCelda, renglon, textoCelda;
            textoBuscar = document.getElementById("busqueda").value.toUpperCase();
            tabla = document.getElementById("tabla");
            renglones = tabla.getElementsByTagName("tr");
            for (renglon = 0; renglon < renglones.length; renglon++) {
                primerCelda = renglones[renglon].getElementsByTagName("td")[0];
                if (primerCelda) {
                    textoCelda = primerCelda.textContent || primerCelda.innerText;
                    if (textoCelda.toUpperCase().indexOf(textoBuscar) > -1) {
                        renglones[renglon].style.display = "";
                    } else {
                        renglones[renglon].style.display = "none";
                    }
                }
            }
        }
    </script>
    <?php
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}