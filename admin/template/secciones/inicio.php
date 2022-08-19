<pre>
<?
include_once(URL_SERVIDOR . '/class/admin.php');
$admin = new admin();

$array_users = $admin->lista_usuarios();
$ejecutivos = $admin->lista_ejecutivos();

if (!empty($_POST) && isset($_GET['g'])) {
    if ($asignado = $admin->asignar($_POST)) {
        $message = '<div class="alert alert-success" role="alert">
            Asignado correctamente. Espere un momento...
        </div>
        <script>setTimeout( function() { window.location.href = "index.php?q=inicio"; }, 3000 );</script>';
    } else {
        $message = '<div class="alert alert-danger" role="alert">
            Hubo un error al asignar el ejecutivo. Intente nuevamente
        </div>';
    }
}

for ($i=0; $i < count($array_users); $i++) { 
    switch ($array_users[$i]['estatus']) {
        case '1':
            $array_users[$i]['estatus'] = '<span class="text-warning">Pendiente</span>';
            break;
        case '2':
            $array_users[$i]['estatus'] = '<span class="text-info">Asignado</span>';
            break;
        case '3':
            $array_users[$i]['estatus'] = '<span class="text-success">Aprobado</span>';
            break;
    }
}
?>
    
    </pre>
<h3 class="mb-2">Listado de usuarios</h3>
<hr>
<?= $message ?>
<div class="table-responsive mt-3">
    <?
    if($_SESSION['apermiso'] == 3)
        include_once(URL_SERVIDOR . '/template/secciones/partials/tabla_usuarios_admin.php');
    else
        include_once(URL_SERVIDOR . '/template/secciones/partials/tabla_usuarios_ejecutivo.php');
    ?>
</div>

<!-- Modal -->
<div class="modal fade" id="asignar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar usuario a un Ejecutivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?q=inicio&g=true" method="POST">
                    <div class="mb-3">
                        <label for="ejecutivo">Selecciona el ejecutivo a cargo</label>
                        <select name="ejecutivo" id="ejecutivo" class="form-select">
                            <option value="">-- Selecciona una opci&oacute;n --</option>
                            <?
                            foreach ($ejecutivos as $ejecutivo) {
                                echo '<option value="' . $ejecutivo['id'] . '">' . $ejecutivo['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="text-end">
                        <input type="hidden" name="user_id" value="" id="user_id">
                        <input type="submit" value="Asignar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>