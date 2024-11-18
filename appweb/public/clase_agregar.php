<?php
session_start();

include '../resources/db/ClaseDB.php';

if (isset($_SESSION['usuario'])) {

    $errores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST['nombre'])) {
            $errores['nombre'] = "se requiere nombre";
        }
        if (empty($_POST['horario'])) {
            $errores['horario'] = "se requiere horario";
        }
        if (empty($_POST['dia'])) {
            $errores['dia'] = "se requiere el dia";
        }
        if (empty($_POST['capacidad'])) {
            $errores['capacidad'] = "se requiere la capacidad";
        }
        if (count($errores) == 0) {

            $claseDB = new ClaseDB();

            if (!$claseDB->existeTipoClase($_POST)) {
                $claseDB->insertaClase($_POST);
                header("Location:inventario.php");
                exit();
            } else {
                $existe = true;
            }
        }
    }

    $PageTitle = "Agregar Clase";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_administrador.html';

    ?>

    <main>

        <div class="text-secondary text-center m-4 ">
            <h2>Agregar Clase</h2>
            <?php if (isset($existe)): ?>
                <h2 class="text-danger">Ya existe esa Clase</h2>
            <?php endif; ?>
        </div>

        <form class="p-5" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

            <div class="mb-3">
                <label class="form-label" for="nombre"style="color: white">Nombre</label>
                <select class="form-select" id="nombre" name="nombre">
                    <option value=""
                            selected="selected">selecciona</option>
                    <?php
                    include '../resources/db/NombreDB.php';
                    $nombreDB = new NombreDB();
                    $nombres =  $nombreDB->getNombre();
                    foreach ($nombres as $nombres):?>
                        <option value="<?= $nombres['id_nombre'] ?>"><?= $nombres['nombre'] ?></option>\n";
                    <?php endforeach; ?>
                </select>
                <span class="text-danger"><?php if (isset($errores['nombre'])) print($errores['nombre']) ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="horario"style="color: white">Horario</label>
                <select class="form-select" id="horario" name="horario">
                    <option value=""
                            selected="selected">selecciona</option>
                    <?php
                    include '../resources/db/HorarioDB.php';
                    $horarioDB = new HorarioDB();
                    $horario =  $horarioDB->getHorarios();
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
            <div class="text-end mt-5">
                <input class="btn btn-primary" type="submit" value="Agregar">
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