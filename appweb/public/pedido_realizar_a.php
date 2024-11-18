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


    $errores = [];
    $noHayTipoLiga = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST['nombre'])) {
            $errores['nombre'] = "se requiere nombre";
        } else {
            $nombre = sanitizacion($_POST['nombre']);
            if (empty($_POST['horario'])) {
                $errores['horario'] = "se requiere horario";
            } else {
                $horario = sanitizacion($_POST['horario']);
                if (empty($_POST['dia'])) {
                    $errores['dia'] = "se requiere el dia";
                } else {
                    $dia = sanitizacion($_POST['dia']);

                    if (count($errores) == 0) {
                        include '../resources/db/ClaseDB.php';
                        $claseDB = new ClaseDB();
                        $idclase = $claseDB->getIdClase($_POST);
                        $confirmar = true;
                        if ($idclase == 0) { // si no hay playeras de ese tipo
                            $noHayTipoClase = true;
                        } else {

                            $_SESSION['clase'] = $idclase;
                            $_SESSION['horario'] = $horario;
                            $_SESSION['nombre'] = $nombre;
                            $_SESSION['dia'] = $dia;

                            header("Location: pedido_realizar_b.php");
                            exit();
                        }
                    }
                }
            }
        }
    }


                $PageTitle = "Realizar pedido";

                include '../resources/templates/head.html';
                include '../resources/templates/header.html';
                include '../resources/templates/navegacion_clientes.html';
                ?>

                <main>

                    <div class="text-secondary text-center m-4">
                        <?php if (!isset($confirmar)): ?>
                            <h2><?php print $_SESSION['usuario'] ?> realiza tu pedido </h2>
                        <?php elseif ($noHayTipoLiga): ?>
                            <h2 class="text-danger ">No hay Ligas con esas características</h2>
                        <?php endif ?>
                    </div>

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="column col-9">

                                <form class="p-5" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

                                    <div class="mb-3">
                                        <label class="form-label" for="nombre" style="color: white">Nombre</label>
                                        <select class="form-select" id="nombre" name="nombre">
                                            <option value=""
                                                    selected="selected">selecciona
                                            </option>
                                            <?php
                                            include '../resources/db/NombreDB.php';
                                            $nombreDB = new NombreDB();
                                            $nombres = $nombreDB->getNombre();
                                            foreach ($nombres as $nombres):?>
                                                <option value="<?= $nombres['id_nombre'] ?>"><?= $nombres['nombre'] ?></option>\n";
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php if (isset($errores['nombre'])) print($errores['nombre']) ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="horario" style="color: white">Horario</label>
                                        <select class="form-select" id="horario" name="horario">
                                            <option value=""
                                                    selected="selected">selecciona
                                            </option>
                                            <?php
                                            include '../resources/db/HorarioDB.php';
                                            $horarioDB = new HorarioDB();
                                            $horario = $horarioDB->getHorarios();
                                            foreach ($horario as $horarios):?>
                                                <option value="<?= $horarios['id_horario'] ?>"><?= $horarios['horario'] ?></option>\n";
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php if (isset($errores['horario'])) print($errores['horario']) ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="dia" style="color: white">Dia</label>
                                        <select class="form-select" id="dia" name="dia">
                                            <option value="" selected="selected">selecciona</option>
                                            <?php
                                            include '../resources/db/DiaDB.php';
                                            $diaDB = new DiaDB();
                                            $dias = $diaDB->getDia();
                                            foreach ($dias as $dia):?>
                                                <option value="<?= $dia['id_dia'] ?>"><?= $dia['dia'] ?></option>\n";
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php if (isset($errores['dia'])) print($errores['dia']) ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="capacidad"style="color: white">Capacidad</label>
                                        <select class="form-select" id="capacidad" name="capacidad">
                                            <option value="" selected="selected">selecciona</option>
                                            <?php
                                            include '../resources/db/CapacidadDB.php';
                                            $capacidadDB = new CapacidadDB();
                                            $capacidades = $capacidadDB->getCapacidad();
                                            foreach ($capacidades as $capacidad):?>
                                                <option value="<?= $capacidad['id_capacidad'] ?>"><?= $capacidad['capacidad'] ?></option>\n";
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php if (isset($errores['capacidad'])) print($errores['capacidad']) ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-warning" type="submit">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>

                <?php

                include '../resources/templates/footer.html';
                include '../resources/templates/scripts.html';
                include '../resources/templates/fin.html';

            }
        else {
                header("Location:login_error.php");
                exit();
            }















