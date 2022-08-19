<pre>
<?
/* ini_set('display_errors', 'on');
ini_set('log_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('error_reporting', E_ALL); */
$arr_usuario = $admin->lista_usuarios_id($_GET['u']);
$datos_generales = json_decode($arr_usuario[0]['datos_generales'], true);
$archivos = json_decode($arr_usuario[0]['documentacion'], true);
$keys_datos = array_keys($datos_generales);
$keys_archivos = array_keys($archivos);

if (isset($_GET['status']) && $_GET['status'] == '3') {
    if ($aprovado = $admin->status_aprobado($arr_usuario[0])) {
        $message = '<div class="alert alert-success" role="alert">
                Usuario aprovado. Espere un momento...
            </div>
            <script>setTimeout( function() { window.location.href = "index.php?q=usuario_detalle&u=' . $_GET['u'] . '"; }, 3000 );</script>';
    }
}

if(isset($_GET['notify']) && $_GET['notify'] == '1' && !empty($_POST)){
    if ($respuesta = $admin->notificar($_POST)) {
        $message = '<div class="alert alert-success" role="alert">
                El usuario fu&eacute; notificado con &eacute;xito.
            </div>';
    }else{
        $message = '<div class="alert alert-danger" role="alert">
            Hubo un error al enviar el correo. Intente nuevamente.
        </div>';
    }
}
?>
</pre>
<div class="d-flex justify-content-between flex-column flex-md-row align-items-center">
    <h3 class="mb-2">Detalle del usuario <?= $arr_usuario[0]['nombre'] ?></h3>
    <div class="text-center my-2">
        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#asignar">
            <i class="bi bi-envelope-exclamation-fill"></i> Notificar correo
        </button>
        <a href="index.php?q=usuario_editar&u=<?= $_GET['u'] ?>" class="btn btn-sm btn-info mx-3"><i class="bi bi-pencil-fill"></i> Editar</a>
        <?
        if ($arr_usuario[0]['estatus'] != 3) {
            echo '<a href="#" data-url="index.php?q=usuario_detalle&u=' . $_GET['u'] . '&status=3" class="btn btn-sm btn-success aprobar"><i class="bi bi-check"></i> Aprobar</a>';
        }
        ?>

    </div>
</div>
<hr>
<?= $message ?>
<div class="d-flex flex-column flex-lg-row justify-content-center gap-4 mt-4">

    <div class="col-lg-3">
        <h4 class="mb-4 text-white p-3 titulo-card">Datos personales</h4>
        <div class="shadow p-4">
            <p><strong>Nombre: </strong><br><?= $arr_usuario[0]['nombre'] ?></p>
            <p><strong>Correo: </strong><br><?= $arr_usuario[0]['correo'] ?></p>
            <p><strong>Tel&eacute;fono: </strong><br><?= $arr_usuario[0]['telefono'] ?></p>
            <p><strong>Folio: </strong><br><?= $arr_usuario[0]['folio'] ?></p>
            <?

            switch ($arr_usuario[0]['estatus']) {
                case '1':
                    $arr_usuario[0]['estatus'] = '<span class="text-warning">Pendiente</span>';
                    break;
                case '2':
                    $arr_usuario[0]['estatus'] = '<span class="text-info">Asignado</span>';
                    break;
                case '3':
                    $arr_usuario[0]['estatus'] = '<span class="text-success">Aprobado</span>';
                    break;
            }

            ?>
            <p><strong>Estatus: </strong><br><?= $arr_usuario[0]['estatus'] ?></p>

        </div>
    </div>
    <div class="col-lg-3">
        <h4 class="mb-4 text-white p-3 titulo-card">Datos generales</h4>
        <div class="shadow p-4">
            <?
            $cont_datos = 0;
            foreach ($datos_generales as $datos) {
                $keys_datos[$cont_datos] = str_replace('_', ' ', $keys_datos[$cont_datos]);

                if (strpos($keys_datos[$cont_datos], 'credito'))
                    $keys_datos[$cont_datos] = str_replace('credito', 'cr&eacute;dito', $keys_datos[$cont_datos]);

                if (strpos($keys_datos[$cont_datos], 'fovissste'))
                    $keys_datos[$cont_datos] = str_replace('fovissste', 'FOVISSSTE', $keys_datos[$cont_datos]);

                if (strpos($keys_datos[$cont_datos], ' issste'))
                    $keys_datos[$cont_datos] = str_replace(' issste', ' ISSSTE', $keys_datos[$cont_datos]);

                

                echo '<p><strong>' . ucfirst($keys_datos[$cont_datos]) . ':</strong> <br> ' . $datos . '</p>';
                $cont_datos++;
            }
            ?>
        </div>
    </div>
    <div class="col-lg-3">
        <h4 class="mb-4 text-white p-3 titulo-card">Documentaci&oacute;n</h4>
        <div class="shadow p-4">
            <?
            $cont_archivos = 0;
            foreach ($archivos as $archivo) {
                $keys_archivos[$cont_archivos] = str_replace('_', ' ', $keys_archivos[$cont_archivos]);

                if (stristr($keys_archivos[$cont_archivos], 'credito'))
                    $keys_archivos[$cont_archivos] = str_replace('credito', 'cr&eacute;dito', $keys_archivos[$cont_archivos]);

                if (stristr($keys_archivos[$cont_archivos], 'talon'))
                    $keys_archivos[$cont_archivos] = str_replace('talon', 'tal&oacute;n', $keys_archivos[$cont_archivos]);

                if (stristr($keys_archivos[$cont_archivos], 'ine'))
                    $keys_archivos[$cont_archivos] = str_replace('ine', 'INE', $keys_archivos[$cont_archivos]);

                if (stristr($keys_archivos[$cont_archivos], 'curp'))
                    $keys_archivos[$cont_archivos] = str_replace('curp', 'CURP', $keys_archivos[$cont_archivos]);

                if (stristr($keys_archivos[$cont_archivos], 'ultimo'))
                    $keys_archivos[$cont_archivos] = str_replace('ultimo', '&Uacute;ltimo', $keys_archivos[$cont_archivos]);

                echo '<p><strong>' . ucfirst($keys_archivos[$cont_archivos]) . ':</strong> <a class="text-danger" target="_blank" href="http://' . $_SERVER['SERVER_NAME'] . '/credito/files/' . $arr_usuario[0]['folio'] . '/' . $archivo . '"> <br><i class="bi bi-file-earmark-pdf-fill"></i> Ver documento</a></p>';
                $cont_archivos++;
            }
            if (empty($archivos))
                echo '<h4 class="text-center fw-bold">Sin archivos</h4>';
            ?>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="asignar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notificar documento faltante o no legible</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?q=usuario_detalle&u=<?= $_GET['u'] ?>&notify=1" method="POST">
                    <div class="mb-3">
                        <label for="nombre">Nombre del usuario</label>
                        <input type="text" name="nombre" id="nombre" value="<?= $arr_usuario[0]['nombre'] ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="correo">Correo del usuario</label>
                        <input type="email" name="correo" id="correo" value="<?= $arr_usuario[0]['correo'] ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="mail">Describa los detalles de los documentos que deben reenviarse</label>
                        <textarea name="mensaje" id="mensaje" rows="10" class="form-control">La siguiente documentación debe reenviarse al correo <?= $_SESSION['amail'] ?> ya que no son legibles o hacen falta: INE, CURP, Comprobante, etc... Puede responder a este correo.</textarea>
                    </div>
                    <div class="text-end">
                        <input type="hidden" name="user_id" value="" id="user_id">
                        <input type="submit" value="Enviar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>