<?php

include_once 'Conexion.php';

class personaDB {

    public function insertaCliente($persona) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO cliente (nombre, apellido_paterno, apellido_materno, correo_electronico) VALUES (?,?,?,?)';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $persona['nombre']);
            $stmt->bindParam(2, $persona['paterno']);
            $stmt->bindParam(3, $persona['materno']);
            $stmt->bindParam(4, $persona['email']);
            $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getUltimoIdInsertado() {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT MAX( id_cliente ) FROM cliente';
            $stmt = $dbh->prepare($consulta);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $id = $resultado[0];
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $id;
    }

    public function existeCorreo($correo) : bool{
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT correo_electronico FROM cliente WHERE correo_electronico = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $correo);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($resultado['correo_electronico']))
            return true;
        else
            return false;
    }

}
