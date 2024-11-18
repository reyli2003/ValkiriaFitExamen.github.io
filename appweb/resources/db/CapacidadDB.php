<?php

include_once 'Conexion.php';

class CapacidadDB {

    public function getCapacidad() {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT * FROM capacidad ORDER BY capacidad';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->execute();
            $capacidad = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $capacidad;
    }

//    public function getTelaById($id) {
//        $conexion = Conexion::getInstancia();
//        $dbh = $conexion->getDbh();
//        try {
//            $consulta = 'SELECT tela FROM tela WHERE idtela = ?';
//            $stmt = $dbh->prepare($consulta);
//            $stmt->setFetchMode(PDO::FETCH_BOTH);
//            $stmt->bindParam(1, $id);
//            $stmt->execute();
//            $resultado = $stmt->fetch();
//            if ($resultado == 0) {
//                $tela = 0;
//            } else {
//                $tela = $resultado['tela'];
//            }
//            $dbh = null; // cierra la conexion
//        } catch (PDOException $e) {
//            echo $e->getMessage();
//        }
//        return $tela;
//    }
}