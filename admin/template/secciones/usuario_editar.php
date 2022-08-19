<pre>
<?
$arr_usuario = $admin->lista_usuarios_id($_GET['u']);
$datos_generales = json_decode($arr_usuario[0]['datos_generales'], true);
$archivos = json_decode($arr_usuario[0]['documentacion'], true);
$keys_datos = array_keys($datos_generales);
$keys_archivos = array_keys($archivos);
if(!empty($_POST)){
    if($arr_usuario = $admin->edita_usuario($_POST, $archivos, $_FILES, $arr_usuario[0])){
        $message = '<div class="alert alert-success" role="alert">
        Los datos se actualizaron con &eacute;xito. Espere un momento...
        </div>
        <script>setTimeout( function() { window.location.href = "index.php?q=usuario_detalle&u=' . $_GET['u'] . '"; }, 3000 );</script>';
    }else{
        $message = '<div class="alert alert-danger" role="alert">
            Hubo un error al Guardar los datos. Intente nuevamente
        </div>';
    }
}
?>

</pre>
<h3 class="mb-3">Editar usuario</h3>
<hr>
<div class="offset-md-3 col-md-6 card-form shadow p-4 rounded overflow-hidden mt-4">
    <?= $message ?>
    <form action="index.php?q=usuario_editar&u=<?=$_GET['u']?>" method="post" enctype="multipart/form-data" id="tipo_credito">
        <?
        for ($i = 0; $i < count($datos_generales); $i++) {
            if ($keys_datos[$i] == 'tipo_de_credito') {
                $disable = 'readonly';
            } else {
                $disable = '';
            }

            $label = str_replace('_', ' ', $keys_datos[$i]);
            echo '<div class="mb-3">
                    <label for="' . $keys_datos[$i] . '">' . ucfirst($label) . '</label>
                    <input type="text" name="' . $keys_datos[$i] . '" id="' . $keys_datos[$i] . '" class="form-control" value="' . $datos_generales[$keys_datos[$i]] . '" ' . $disable . '>
                </div>';
        }

        for ($j = 0; $j < count($archivos); $j++) {
            $label_archivos = str_replace('_', ' ', $keys_archivos[$j]);
            echo '<div class="mb-3">
                    <label for="' . $keys_archivos[$j] . '">' . ucfirst($label_archivos) . '</label>
                    <input type="file" name="' . $keys_archivos[$j] . '" id="' . $keys_archivos[$j] . '" class="form-control input_validate" value=' . $archivos[$keys_archivos[$j]] . '>
                </div> ';
        }
        ?>
        <div class="form-group float-end mt-3">
            <input type="submit" value="Editar" class="btn btn-form">
        </div>
    </form>
</div>