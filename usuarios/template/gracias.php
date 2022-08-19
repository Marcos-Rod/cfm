<?
$status = $user->consulta_status($_SESSION['umail']);

switch ($status[0]['estatus']) {
    case '1':
        $estatus = '<span class="text-warning">Pendiente</span>';
        break;
    case '2':
        $estatus = '<span class="text-info">Asignado</span>';
        break;
    case '3':
        $estatus = '<span class="text-success">Aprobado</span>';
        break;
}
?>
<div class="offset-md-2 col-md-8 card-form shadow p-4 rounded overflow-hidden text-center">
    <?= $message ?>
    <h2>!Registro exitoso¡</h2>
    <?
    switch ($status[0]['estatus']) {
        case 1:
            echo '<h4>Un ejecutivo ser&aacute; asignado para la revisi&oacute;n de sus documentos</h4>';
            break;
        case 2:
            echo '<h4>Sus documentos est&aacute;n siendo validados</h4>';
            break;
        case 3:
            echo '<h4>Su solicitud fue aprobada</h4>';
            break;
        
        default:
            # code...
            break;
    }
        
    ?>
    <p>&nbsp;</p>
    <p><strong>Estatus: </strong><?=$estatus?></p>
    <?
    if($status[0]['estatus'] == 3)
        echo '<p><a href="" class="btn btn-info">Siguiente <i class="bi bi-chevron-double-right"></i></a></p>';
    ?>
</div>