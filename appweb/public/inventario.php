<?php
$PageTitle = "Index";
include '../resources/templates/header.html';
include  '../resources/templates/head.html';
include '../resources/templates/navegacion_administrador.html';


?>
<main>

    <div class="text-warning text-center m-4 ">
        <h2>Clases en existencia</h2>
    </div>

    <div class="text-end m-4">
        <a class="btn btn-warning" href="clase_agregar.php">Agregar Clase</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center"style="color: white"> horario</th>
            <th class="text-center"style="color: white"> dia</th>
            <th class="text-center"style="color: white"> capacidad</th>
            <th class="text-center"style="color: white"> en existencia</th>
            <th class="text-center"style="color: white"> modificar existencia</th>

        </tr>
        </thead>
        <tbody>
        <?php
        include './../resources/db/ClaseDB.php';
        $claseDB = new ClaseDB();
        $clases = $claseDB->getClase();
        foreach ($clases as $clase):?>
            <tr>
                <td class="text-center"style="background: gray"><?= $clase['horario'] ?></td>
                <td class="text-center"style="background: gray"><?= $clase['dia'] ?></td>
                <td class="text-center"style="background: gray"><?= $clase['capacidad'] ?></td>
                <td class="text-center"style="background: gray"><?= $clase['existencia'] ?></td>
                <td class="text-center">
                    <form action="./../public/clase_modificar.php" method="POST">
                        <input type="number" id="cantidad" name="cantidad" size="4">
                        <input type="hidden" id="id_clase" name="id_clase" value="<?= $clase['id_clase'] ?>">
                        <input class="btn btn-warning" type="submit" value="Modificar">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
include '../resources/templates/fin.html';