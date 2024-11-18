<table class="table table-striped">
    <thead>
    <tr>
        <th class="text-center"> horario</th>
        <th class="text-center"> dia</th>
        <th class="text-center"> capacidad</th>
        <th class="text-center"> en existencia</th>
        <th class="text-center"> modificar existencia</th>

    </tr>
    </thead>
    <tbody>
    <?php
    include '../../resources/db/ClaseDB.php';
    $claseDB = new ClaseDB();
    $clases = $claseDB->getClase();
    foreach ($clases as $clase):?>
        <tr>
            <td class="text-center"><?= $clase['horario'] ?></td>
            <td class="text-center"><?= $clase['dia'] ?></td>
            <td class="text-center"><?= $clase['capacidad'] ?></td>
            <td class="text-center"><?= $clase['existencia'] ?></td>
            <td class="text-center">
                <form action="../../public/clase_modificar.php" method="POST">
                    <input type="number" id="cantidad" name="cantidad" size="4">
                    <input type="hidden" id="id_clase" name="id_clase" value="<?= $clase['id_clase'] ?>">
                    <input class="btn btn-primary" type="submit" value="Modificar">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>