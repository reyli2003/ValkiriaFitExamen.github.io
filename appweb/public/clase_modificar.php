<?php
session_start();
if (isset($_SESSION['usuario'])) {
    include '../resources/db/ClaseDB.php';
    $claseDB = new ClaseDB();
    $existencia = $claseDB->getExistenciaporId($_POST['id_clase']);
    $cantidad = $existencia + $_POST['cantidad'];
    $claseDB->modificaCantidadClasesPorId($_POST['id_clase'], $cantidad);
    header("Location:inventario.php");
    exit();

} else {
    header("Location:login_error.php");
    exit();
}
