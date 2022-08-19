<table id="usuarios_table" class="table table-striped table-bordered table-hover" style="width:100%">
    <thead>
        <tr>
            <th># ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tel&eacute;fono</th>
            <th>Folio</th>
            <th>Estatus</th>
            <th style="min-width: 115px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?
        foreach ($array_users as $user) {
            echo '<tr>
                        <td>' . $user['id'] . '</td>
                        <td>' . $user['nombre'] . '</td>
                        <td><a href="mailto:' . $user['correo'] . '">' . $user['correo'] . '</a></td>
                        <td>' . $user['telefono'] . '</td>
                        <td>' . $user['folio'] . '</td>
                        <td style="text-align: center;">' . $user['estatus'] . '<br>' . $user['ejecutivo_asignado'] . '</td>
                        <td style="text-align:center;">
                            <button type="button" class="btn btn-sm btn-success asignar" data-bs-toggle="modal" data-bs-target="#asignar" data-bs-user="' . $user['id'] . '">
                            <i class="bi bi-person-fill"></i> Asignar
                            </button>
                            <a href="index.php?q=usuario_detalle&u=' . $user['id'] . '" class="btn btn-sm btn-primary"><i class="bi bi-file-pdf-fill"></i> Ver documentos</a>
                        </td>
                    </tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tel&eacute;fono</th>
            <th>Folio</th>
            <th>Estatus</th>
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>