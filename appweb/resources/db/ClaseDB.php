<?php

include_once 'Conexion.php';

class ClaseDB {

    public function existeTipoClase($clase) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT * FROM clase WHERE fk_horario = ? AND fk_dia = ? AND fk_capacidad = ? AND fk_nombre = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->bindValue(1, $clase['horario']);
            $stmt->bindValue(2, $clase['dia']);
            $stmt->bindValue(3, $clase['capacidad']);
            $stmt->bindValue(4, $clase['nombre']);
            $stmt->execute();
            $cantidad = $stmt->rowCount();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if ($cantidad != 0)
            $resultado = true;
        else
            $resultado = false;
        return $resultado;
    }

    public function getIdClase($clase) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT id_clase FROM clase WHERE fk_horario = ? AND fk_dia = ? AND fk_capacidad = ? AND fk_nombre = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->bindValue(1, $clase['horario']);
            $stmt->bindValue(2, $clase['dia']);
            $stmt->bindValue(3, $clase['capacidad']);
            $stmt->bindValue(4, $clase['nombre']);

            $stmt->execute();
            $resultado = $stmt->fetch();
            if ($resultado == 0) {
                    $idClase = 0;
            } else {
                $idClase = $resultado['id_clase'];
            }
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $idClase;
    }

    public function getExistenciaporId($idClase){
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT existencia FROM clase WHERE id_clase = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->bindValue(1, $idClase);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $existencia = $resultado['existencia'];
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $existencia;
    }

    public function modificaCantidadClasesPorId($idClase, $cantidad) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'UPDATE clase SET existencia = ? WHERE id_clase= ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $cantidad);
            $stmt->bindParam(2, $idClase);
            $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertaClase($clase) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO clase (fk_horario, fk_dia, fk_capacidad, existencia, fk_nombre) VALUES (?,?,?,?,?)';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->bindParam(1, $clase['horario']);
            $stmt->bindParam(2, $clase['dia']);
            $stmt->bindParam(3, $clase['capacidad']);
            $stmt->bindValue(4, 0);
            $stmt->bindParam(5, $clase['nombre']);

            $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getClase() {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT id_clase, horario.horario, dia.dia, capacidad.capacidad, existencia, nombre.nombre FROM clase '
                . 'JOIN horario ON clase.fk_horario = horario.id_horario '
                . 'JOIN dia ON clase.fk_dia = dia.id_dia '
                . 'JOIN capacidad ON clase.fk_capacidad = capacidad.id_capacidad '
                . 'JOIN nombre ON clase.fk_nombre = nombre.id_nombre '
                . 'ORDER BY horario, dia, capacidad, nombre';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $playeras = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $playeras;
    }



    public function eliminaClaseById($idClase) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'DELETE FROM clase WHERE id_clase = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $idClase);
            $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

//$playeraDB = new PlayeraDB();
//print('<pre>');
//print_r($playeraDB->getPlayeras());
//print('</pre>');