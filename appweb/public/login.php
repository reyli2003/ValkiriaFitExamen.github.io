<?php
session_start();
include '../resources/db/UsuarioDB.php';
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["usuario"])) {
        $errores['usuario'] = "Se requiere el nombre";
    } else {
        $usuario = $_POST["usuario"];
    }
    if (empty($_POST["contrasenia"])) {
        $errores['contrasenia'] = "Se requiere la contraseña";
    } else {
        $contrasenia = $_POST["contrasenia"];
    }
    if (count($errores) == 0) {
        $usuarioDB = new UsuarioDB();
        $passwordHasheado = $usuarioDB->getPasswordHashByUser($_POST['usuario']);
        if (password_verify($_POST['contrasenia'], $passwordHasheado)) {
            $_SESSION['usuario'] = $_POST['usuario'];
            $consulta = $usuarioDB->getUsuarioTipoCientePorUsuario($_POST['usuario']);
            $tipoUsuario = $consulta['tipo_usuario'];
            $_SESSION['id_usuario'] = $consulta['id_usuario'];
            if ($tipoUsuario == 'administrador') {
                header("Location:vista_administrador.php");
            } else {
                header("Location:vista_cliente.php");
            }
            exit();
        } else { // Usuario o password inválido
            header("Location:login_error.php");
            exit();
        }
    }
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <!-- CSS-->
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background: url("./assets/images/login.jpeg");
            background-size: cover;
            background-attachment: fixed;
        }
        * {
            box-sizing: border-box;
        }
        .contenedor {
            width: 100%;
            padding: 15px;
        }
        .formulario {
            background: #fff;
            margin-top: 150px;
            padding: 3px;
        }
        h1 {
            text-align: center;
            color: #1a2537;
            font-size: 40px;
        }
        input[type="text"],
        input[type="password"] {
            font-size: 20px;
            width: 82%;
            padding: 10px;
            border: none;
        }
        .input-contenedor {
            margin-bottom: 15px;
            border: 1px solid #aaa;
        }
        .icon {
            min-width: 50px;
            text-align: center;
            color: #999;
        }
        .button {
            border: none;
            width: 100%;
            color: white;
            font-size: 20px;
            background: #1a2537;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background: cadetblue;
        }
        p {
            text-align: center;
        }
        .link {
            text-decoration: none;
            color: #1a2537;
            font-weight: 600;
        }
        .link:hover {
            color: cadetblue;
        }
        @media(min-width: 768px) {
            .formulario {
                margin: auto;
                width: 500px;
                margin-top: 150px;
                border-radius: 2%;
            }
        }
    </style>
</head>
<body>
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="formulario" novalidate>
    <h1>Login</h1>
    <div class="contenedor">

        <div class="input-contenedor">
            <i class="fas fa-envelope icon"></i>
            <input class="form-control" type="text" name="usuario" placeholder="Usuario" required>
            <span class="text-danger"><?php if (isset($errores['usuario'])) print($errores['usuario']) ?></span>
        </div>
        <div class="input-contenedor">
            <i class="fas fa-key icon"></i>
            <input class="form-control" type="password" name="contrasenia" placeholder="Contraseña" required>
            <span class="text-danger"><?php if (isset($errores['contrasenia'])) print($errores['contrasenia']) ?></span>
        </div>
        <input type="submit" value="Login" class="button">

        <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
        <p>¿No tienes una cuenta? <a class="link" href="registrarvista.php">Regístrate </a></p>

    </div>
</form>

</body>
</html>