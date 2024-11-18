<?php

include_once 'Conexion.php';

class UsuarioDB
{

    public function insertaUsuario($id, $usuario)
    {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO usuario ( fk_idcliente, usuario, contrasenia, tipo_usuario) VALUES (?,?,?,?)';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $usuario['usuario']);
            $stmt->bindValue(3, password_hash($usuario['contrasenia'], PASSWORD_DEFAULT));
            $stmt->bindValue(4, 'cliente');
            $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function existeUsuario($usuario)
    {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT id_usuario FROM usuario WHERE usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($resultado['id_usuario']))
            return true;
        else
            return false;
    }

    public function getPasswordHashByUser($usuario)
    {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT contrasenia FROM usuario WHERE usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($resultado['contrasenia']))
            return $resultado['contrasenia'];
        else
            return 0;
    }

    public function getUsuarioTipoCientePorUsuario($usuario)
    {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT tipo_usuario, id_usuario FROM usuario WHERE usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    public function getUsuariosClientes()
    {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT usuario, cliente.nombre, cliente.apellido_paterno,cliente.apellido_materno, cliente.correo_electronico FROM usuario '
                . 'JOIN cliente  ON usuario.fk_idcliente = cliente.id_cliente  '
                . 'WHERE tipo_usuario = "cliente" '
                . 'ORDER BY id_cliente ';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $clientes= $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $clientes;
    }
}