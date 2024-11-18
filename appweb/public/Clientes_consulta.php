<?php
session_start();
//if (isset($_SESSION['usuario'])) {
if (true) {

    $PageTitle = "Clientes";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_administrador.html';

    ?>

    <main>

        <div class="text-warning text-center m-4 ">
            <h2>Clientes</h2>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="text-center"style="color:white">Usuario</th>
                <th class="text-center"style="color:white">Nombre</th>
                <th class="text-center"style="color:white">Ap paterno</th>
                <th class="text-center"style="color:white">Ap materno</th>
                <th class="text-center"style="color:white">e-mail</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include '../resources/db/UsuarioDB.php';
            $usuarioBD = new UsuarioDB();
            $clientes = $usuarioBD->getUsuariosClientes();
            foreach ($clientes as $cliente):?>
                <tr>
                    <td  class="text-center"style="background:darkgoldenrod"><?= $cliente['usuario'] ?></td>
                    <td class="text-center"style="background: dimgray"><?= $cliente['nombre'] ?></td>
                    <td class="text-center"style="background:darkgoldenrod"><?= $cliente['apellido_paterno'] ?></td>
                    <td class="text-center"style="background: dimgray"><?= $cliente['apellido_materno'] ?></td>
                    <td class="text-center"style="background: darkgoldenrod"><?= $cliente['correo_electronico'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </main>

    <?php

    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}