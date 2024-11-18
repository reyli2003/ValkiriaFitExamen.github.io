<?php
session_start();
if (isset($_SESSION['usuario'])) {

    include '../resources/db/ReservacionDB.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_reservacion = $_POST['id_reservacion'];

        $pedidoDB = new ReservacionDB();
        if ($pedidoDB->eliminarReservacion($id_reservacion)) {
            echo "pedido eliminado exitosamente";
        } else {
            echo "Error al eliminar el pedido";
        }
    }
} else {
    header("Location: login_error.php");
    exit();
}
?>

