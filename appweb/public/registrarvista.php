<?php
include '../resources/db/PersonaDB.php';
include '../resources/db/UsuarioDB.php';

function sanitizacion($data)
{
    $data = trim($data); // Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadna
    $data = stripslashes($data); // (\) se convierte en () y Barras invertidas dobles (\\) se convierten en una sencilla (\).
    $data = htmlspecialchars($data); // ejemplo convierte <a href='test'>Test</a> en &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt
    return $data;
}

$errores = [];
$nombre = $paterno = $materno  = $usuario = $email = $contrasenia = $contrasenia2 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nombre"])) {
        $errores['nombre'] = "Se requiere el nombre.";
    } else {
        $nombre = sanitizacion($_POST["nombre"]);
    }

    if (empty($_POST["paterno"])) {
        $errores['paterno'] = "Se requiere el apellido paterno.";
    } else {
        $paterno = sanitizacion($_POST["paterno"]);
    }

    if (empty($_POST["materno"])) {
        $errores['materno'] = "Se requiere el apellido materno.";
    } else {
        $materno = sanitizacion($_POST["materno"]);
    }
    if (empty($_POST["usuario"])) {
        $errores['usuario'] = "se requiere el usuario";
    } else {
        $usuario = sanitizacion($_POST["usuario"]);
    }
    if (empty($_POST["email"])) {
        $errores['email'] = "se requiere un email";
    } else {
        $email = sanitizacion($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "No es un formato válido de email";
        }
    }
    if (empty($_POST["contrasenia"])) {
        $errores['contrasenia'] = "se requiere la contraseña ";
    } else {
        $contrasenia = sanitizacion($_POST["contrasenia"]);
    }
    if (empty($_POST["contrasenia2"])) {
        $errores['contrasenia2'] = "se requiere la confirmación de la contraseña ";
    } else {
        $contrasenia2 = sanitizacion($_POST["contrasenia2"]);
    }
    if (strcmp($contrasenia, $contrasenia2) != 0) {
        $errores['contrasenia'] = "las contraseñas no coinciden";
    }
    if (count($errores) == 0) {
        $personaDB = new PersonaDB();
        $usuarioDB = new UsuarioDB();

        if (!$personaDB->existeCorreo($_POST['email']) && !$usuarioDB->existeUsuario($_POST['usuario'])) {
            $personaDB->insertaCliente($_POST);
            $idReceinte = $personaDB->getUltimoIdInsertado();
            $usuarioDB->insertaUsuario($idReceinte, $_POST);
            header("Location: login.php");
            exit();
        } else {
            if ($personaDB->existeCorreo($_POST['email'])) {
                ?>
                <div class="text-center m-5 p-5 text-danger ">
                    <h2>Ya existe un registro con ese correo electrónico</h2>
                </div>
                <?php
            } else {
                ?>
                <div class="text-center m-5 p-5 text-danger ">
                    <h2>Ya existe un registro con ese nombre de usuario</h2>
                </div>
                <?php
            }
        }
    }
}
$PageTitle = "Registro";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background: url("./assets/images/usuarios.jpeg");
            background-size: cover;
            background-attachment: fixed;
        }

        .formulario {
            background: #fff;
            padding: 20px;
            margin: 50px auto;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .input-contenedor {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border: 1px solid #aaa;
            border-radius: 5px;
            padding: 10px;
        }

        .input-contenedor i {
            color: #999;
            margin-right: 10px;
        }

        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
        }

        .button {
            width: 100%;
            padding: 15px;
            background-color: #1a2537;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
        }

        .button:hover {
            background-color: cadetblue;
        }

        .text-danger {
            color: red;
            font-size: 14px;
        }

        p {
            text-align: center;
        }

        .link {
            color: #1a2537;
            text-decoration: none;
        }

        .link:hover {
            color: cadetblue;
        }
    </style>
</head>
<body>
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="formulario" novalidate>
    <h1>Registrate</h1>
    <div class="input-contenedor">
        <i class="fas fa-user icon"></i>
        <input type="text" name="nombre" placeholder="Nombre " value="<?= $nombre ?>">
        <span class="text-danger"><?php if (isset($errores['nombre'])) print($errores['nombre']) ?></span>
    </div>

    <div class="input-contenedor">
        <i class="fas fa-user icon"></i>
        <input type="text" name="paterno" placeholder="Apellido Paterno" value="<?= $paterno ?>">
        <span class="text-danger"><?php if (isset($errores['paterno'])) print($errores['paterno']) ?></span>
    </div>

    <div class="input-contenedor">
        <i class="fas fa-user icon"></i>
        <input type="text" name="materno" placeholder="Apellido Materno" value="<?= $materno ?>">
        <span class="text-danger"><?php if (isset($errores['materno'])) print($errores['materno']) ?></span>
    </div>

    <div class="input-contenedor">
        <i class="fas fa-user icon"></i>
        <input type="text" name="usuario" placeholder="Usuario" value="<?= $usuario ?>">
        <span class="text-danger"><?php if (isset($errores['usuario'])) print($errores['usuario']) ?></span>
    </div>

    <div class="input-contenedor">
        <i class="fas fa-envelope icon"></i>
        <input type="email" name="email" placeholder="Correo Electrónico" value="<?= $email ?>">
        <span class="text-danger"><?php if (isset($errores['email'])) print($errores['email']) ?></span>
    </div>

    <div class="input-contenedor">
        <i class="fas fa-key icon"></i>
        <input type="password" name="contrasenia" placeholder="Contraseña">
        <span class="text-danger"><?php if (isset($errores['contrasenia'])) print($errores['contrasenia']) ?></span>
    </div>

    <div class="input-contenedor">
        <i class="fas fa-key icon"></i>
        <input type="password" name="contrasenia2" placeholder="Repetir Contraseña">
        <span class="text-danger"><?php if (isset($errores['contrasenia2'])) print($errores['contrasenia2']) ?></span>
    </div>

    <input type="submit" value="Registrate" class="button">
    <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
    <p>¿Ya tienes una cuenta? <a class="link" href="login.php">Iniciar Sesión</a></p>
</form>
</body>
</html>
<script>
    let password = document.getElementById("contrasenia")
    let confirm_password = document.getElementById("contrasenia2");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Las contraseñas no coinciden");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>