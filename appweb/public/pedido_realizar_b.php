<?php
session_start();
if (isset($_SESSION['usuario'])) {

    function sanitizacion($data)
    {
        $data = trim($data); // Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadna
        $data = stripslashes($data); // (\) se convierte en () y Barras invertidas dobles (\\) se convierten en una sencilla (\).
        $data = htmlspecialchars($data); // ejemplo convierte <a href='test'>Test</a> en &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errores = [];
        if (empty($_POST['propietario'])) {
            print('chja');
            $errores['propietario'] = "se requiere el nombre del propietario";
        } else {
            $nombre = sanitizacion($_POST["propietario"]);
        }
        if (empty($_POST["numTarjeta"])) {
            $errores['numTarjeta'] = "Número de tarjeta no válido";
        } else {
            $numTarjeta = sanitizacion($_POST["numTarjeta"]);
            if (!filter_var($numTarjeta, FILTER_VALIDATE_INT)) {
                $errores['numTarjeta'] = "No es un número entero";
            }
        }
        if (empty($_POST["cvv"])) {
            $errores['cvv'] = "CVV no válido";
        } else {
            $cvv = sanitizacion($_POST["cvv"]);
            if (!filter_var($cvv, FILTER_VALIDATE_INT)) {
                $errores['numero'] = "No es un número entero";
            }
        }
        if (empty($_POST["mes"])) {
            $errores['mes'] = "elige un mes";
        } else {
            $mes = sanitizacion($_POST["mes"]);
        }
        if (empty($_POST["anio"])) {
            $errores['anio'] = "elige un año";
        } else {
            $anio = sanitizacion($_POST["anio"]);
        }
        if (count($errores) == 0) {
            header("Location:pedido_realizar_c.php");
            exit();
        }
    }


    $PageTitle = "Confirmar pedido";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_clientes.html';
    ?>

    <main>

        <div class="text-secondary text-center m-5">
            <h2><?php print $_SESSION['usuario'] ?> verifica los detalles de tu reservacion</h2>
        </div>

        <?php
        $costo=50;


        //inserta pedido
        include '../resources/db/ReservacionDB.php';
        $reservacionBD = new ReservacionDB();
        print_r($costo);
        $reservacionBD->insertaReservacion($_SESSION['clase'], $_SESSION['id_usuario'], $costo);

        // obtiene pedido
        $idReservacion = $reservacionBD->getMaxId();
        $reservacion = $reservacionBD->getReservacionPorId($idReservacion);
        $_SESSION['id_reservacion'] = $idReservacion;
        ?>


        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="column col-6 mb-3">
                        <div class="row justify-content-center">
                            <div class="column col-6 mb-3">
                                <label class="form-label" for="horario"style="color: white">Horario:</label>
                                <input class="form-control" type="text" name="horario" readonly="readonly"
                                       value="<?= $reservacion['horario'] ?>">
                            </div>
                            <div class="column col-6 mb-3">
                                <label class="form-label" for="nombre"style="color: white">Nombre:</label>
                                <input class="form-control" type="text" name="nombre" readonly="readonly"
                                       value="<?= $reservacion['nombre'] ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="column col-6 mb-3">
                                <label class="form-label" for="dia"style="color: white">Dia:</label>
                                <input class="form-control" type="text" name="dia" readonly="readonly"
                                       value="<?= $reservacion['dia'] ?>">
                            </div>
                            <div class="column col-6 mb-3">
                                <label class="form-label" for="costo"style="color: white">Costo:</label>
                                <input class="form-control" type="textarea" name="costo" readonly="readonly"
                                       value="$<?= $reservacion['importe'] ?>">
                            </div>
                        </div>
                    </div>

                <div class="text-secondary text-center m-5">
                    <h2>Realiza el pago</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="column col-5 mb-3">
                        <label for="propietario" style="color: white;">Propietario</label>

                        <input type="text" class="form-control" name="propietario">
                        <span class="text-danger"><?php if (isset($errores['propietario'])) print($errores['propietario']) ?></span>
                    </div>
                    <div class="column col-3 mb-3">
                        <label for="cvv" style="color: white;">CVV</label>
                        <input type="text" class="form-control" name="cvv">
                        <span class="text-danger"><?php if (isset($errores['cvv'])) print($errores['cvv']) ?></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="column col-8 mb-3">
                        <label for="numTarjeta" style="color: white;">Número de tarjeta</label>
                        <input type="text" class="form-control" name="numTarjeta">
                        <span class="text-danger"><?php if (isset($errores['numTarjeta'])) print($errores['numTarjeta']) ?></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="column col-8 mb-3">
                        <label class="form-label" style="color: white;">Fecha de expiración</label>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="column col-3 mb-3">
                        <select class="form-select" name="mes">
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                        <span class="text-danger"><?php if (isset($errores['mes'])) print($errores['mes']) ?></span>
                    </div>
                    <div class="column col-3 mb-3">
                        <select class="form-select" name="anio">
                            <option value="23">2023</option>
                            <option value="24">2024</option>
                            <option value="25">2025</option>
                            <option value="26">2026</option>
                            <option value="27">2027</option>
                            <option value="28">2028</option>
                        </select>
                        <span class="text-danger"><?php if (isset($errores['anio'])) print($errores['anio']) ?></span>
                    </div>
                    <div class="column col-2 mb-3 ">
                        <img src="assets/img/visa.jpg" id="visa">
                        <img src="assets/img/mastercard.jpg" id="mastercard">
                    </div>
                </div>
                <div class="row justify-content-center mt-5">
                    <div class="column col-3 mb-3">
                        <div class="mb-3">
                            <a class="btn btn-danger mx-3" href="pedido_realizar_a.php"
                               role="button">Cancelar</a>
                            <button class="btn btn-primary" type="submit">Pagar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <?php

    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}
