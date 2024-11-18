<?php
$PageTitle = "Error";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $PageTitle ?></title>
    <style>
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 32px;
            background-color: #1a2537;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: cadetblue;
        }
    </style>
</head>
<body>
<main>        <a href="index.html" class="btn">Regresar al Inicio</a>

    <div class="text-center">
        <img src="assets/images/acceso-denegado-2.jpeg" alt="Acceso Denegado" width="900" height="300">
    </div>
</main>

</body>
</html>
