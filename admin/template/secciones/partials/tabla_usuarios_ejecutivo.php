<?
$array_users_ejecutivo = $admin->lista_usuarios_ejecutivo_id($_SESSION['admin_id']);

?>
<table id="usuarios_table" class="table table-striped table-bordered table-hover" style="width:100%">
    <thead>
        <tr>
            <th># ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tel&eacute;fono</th>
            <th>Folio</th>
            <th style="min-width: 115px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?
        foreach ($array_users_ejecutivo as $user) {
            echo '<tr>
                        <td>' . $user['id'] . '</td>
                        <td>' . $user['nombre'] . '</td>
                        <td>' . $user['correo'] . '</td>
                        <td>' . $user['telefono'] . '</td>
                        <td>' . $user['folio'] . '</td>
                        <td style="text-align:center;">
                            <a href="index.php?q=usuario_detalle&u=' . $user['id'] . '" class="btn btn-sm btn-primary">Ver documentos</a>
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
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>