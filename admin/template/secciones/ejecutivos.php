<?
if ($_SESSION['apermiso'] == 3) {
    $ejecutivos = $admin->lista_ejecutivos();
    if (!empty($_POST) && isset($_GET['d'])) {
        if ($admin->eliminar_ejecutivo($_POST['aid'])) {
            $message = '<div class="alert alert-success" role="alert">
            Eliminado correctamente. Espere un momento...
        </div>
        <script>setTimeout( function() { window.location.href = "index.php?q=ejecutivos"; }, 3000 );</script>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">
            Hubo un error al eliminar el registro. Intente nuevamente
        </div>';
        }
    }
?>

    <h3 class="mb-2">Listado de ejecutivos</h3>
    <hr>
    <?= $message ?>
    <p class="text-end"><a href="index.php?q=ejecutivos_nuevo" class="btn btn-secondary">Nuevo ejecutivo</a></p>
    <div class="table-responsive">
        <table id="usuarios_table" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 45px;"># ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th style="min-width: 115px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach ($ejecutivos as $ejecutivo) {
                    echo '<tr>
                        <td>' . $ejecutivo['id'] . '</td>
                        <td>' . $ejecutivo['nombre'] . '</td>
                        <td>' . $ejecutivo['correo'] . '</td>
                        <td style="text-align:center;">
                            <div class="d-flex justify-content-center gap-3">
                                <!--<a href="#" class="btn btn-warning btn-sm">Editar</a>-->
                                <form action="index.php?q=ejecutivos&d=true" method="post" name="eliminar" id="eliminar">
                                    <input type="hidden" name="aid" value="' . $ejecutivo['id'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm delsec"><i class="bi bi-trash-fill"></i> Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th># ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th style="min-width: 115px;">Acciones</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?
} else {
    echo '<div class="text-center">
            <h2>P&aacute;gina no encontrada :(</h2>
            <p>Usuario no Autorizado</p>
        </div>';
}
?>