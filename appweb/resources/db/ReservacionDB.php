<?php

include_once 'Conexion.php';

class ReservacionDB {

    public function insertaReservacion($idClase, $idUsuario, $importe) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO reservacion (fk_clase, fk_usuario, importe, fecha_orden) VALUES(?,?,?,now())';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->bindValue(1, $idClase);
            $stmt->bindValue(2, $idUsuario);
            $stmt->bindValue(3, $importe);
            $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getMaxId(): int {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT MAX(id_reservacion) FROM reservacion';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->execute();
            $resultado = $stmt->fetch();
            if ($resultado == 0) {
                $idPedido = 0;
            } else {
                $idPedido = $resultado[0];
            }
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $idPedido;
    }

    public function getReservacionPorId($id) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT horario.horario, dia.dia, capacidad.capacidad, nombre.nombre ,importe FROM reservacion '
                . 'JOIN clase ON reservacion.fk_clase = clase.id_clase '
                . 'JOIN horario ON clase.fk_horario = horario.id_horario '
                . 'JOIN dia ON clase.fk_dia = dia.id_dia '
                . 'JOIN capacidad ON clase.fk_capacidad = capacidad.id_capacidad '
                . 'JOIN nombre ON clase.fk_nombre = nombre.id_nombre '
                . 'WHERE id_reservacion = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $reservacion = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $reservacion;
    }


    public function getReservacionPorUsuario($id) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta ='SELECT horario.horario, dia.dia, capacidad.capacidad, nombre.nombre ,importe FROM reservacion '
                . 'JOIN clase ON reservacion.fk_clase = clase.id_clase '
                . 'JOIN horario ON clase.fk_horario = horario.id_horario '
                . 'JOIN dia ON clase.fk_dia = dia.id_dia '
                . 'JOIN capacidad ON clase.fk_capacidad = capacidad.id_capacidad '
                . 'JOIN nombre ON clase.fk_nombre = nombre.id_nombre '
                . 'WHERE fk_usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $reservacion = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $reservacion;
    }

    public function getReservacion() {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT reservacion.id_reservacion,usuario,horario.horario, dia.dia, capacidad.capacidad, nombre.nombre ,importe FROM reservacion '
                . 'JOIN clase ON reservacion.fk_clase = clase.id_clase '
                . 'JOIN horario ON clase.fk_horario = horario.id_horario '
                . 'JOIN dia ON clase.fk_dia = dia.id_dia '
                . 'JOIN capacidad ON clase.fk_capacidad = capacidad.id_capacidad '
                . 'JOIN nombre ON clase.fk_nombre = nombre.id_nombre '
                . 'JOIN usuario ON reservacion.fk_usuario= usuario.id_usuario' ;
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $reservacion = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $reservacion;
    }

    public function eliminarReservacion($id_reservacion) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'DELETE FROM reservacion WHERE id_reservacion = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $id_reservacion);
            $stmt->execute();
            $dbh = null; // Cierra la conexión
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}