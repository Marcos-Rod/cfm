<?
if (!empty($_POST)) {

    $resultado = $user->procesar_datos($_POST, $_FILES);
    switch ($resultado) {
        case 1:
            $message = '<div class="alert alert-success" role="alert">
                    Los datos se enviaron con &eacute;xito
                </div>
                <script>setTimeout( function() { window.location.href = "index.php?q=gracias"; }, 3000 );</script>';
            break;

        case 3:
            $message = '<div class="alert alert-warning" role="alert">
                    Solo son permitidos archivos con formato PDF.
                </div>';
            break;

        case 4:
            $message = '<div class="alert alert-warning" role="alert">
                    Hubo un error al enviar el correo. <a href="index.php">Intente nuevamente</a>
                </div>';
            break;

    }
}
?>

<h2 class="text-center">Tipo de cr&eacute;dito</h2>
<div class="offset-md-3 col-md-6 card-form shadow p-4 rounded overflow-hidden">
    <?= $message ?>
    <form action="index.php?f=tipo_credito" method="post" enctype="multipart/form-data" id="tipo_credito">
        <div class="form-group mb-3">
            <label for="credito_tipo">Selecciona el tipo de cr&eacute;dito</label>
            <select name="tipo_de_credito" id="tipo_de_credito" class="form-select">
                <option value=""> -- Selecciona una opci&oacute;n --</option>
                <option value="MEJORAVIT" id="1">MEJORAVIT</option>
                <option value="C. PARA PENSIONADOS" id="2">C. PARA PENSIONADOS</option>
                <option value="C. RENOVA" id="3">C. RENOVA</option>
                <option value="C. PYME" id="4">C. PYME</option>
                <option value="C. NÓMINA" id="5">C. NÓMINA</option>
                <option value="C. TRADICIONAL" id="6">C. TRADICIONAL</option>
                <option value="C. FOVISSSTE - INFONAVIT INDIVIDUAL" id="7">C. FOVISSSTE - INFONAVIT INDIVIDUAL</option>
                <option value="C. MANCOMUNADO" id="8">C. MANCOMUNADO</option>
                <option value="C. HIPOTECARIO CONYUGAL FOVISSSTE - INFONAVIT" id="9">C. HIPOTECARIO CONYUGAL FOVISSSTE - INFONAVIT</option>
            </select>
        </div>
        <div class="form-group" id="documentacion"></div>
        <div class="form-group float-end mt-3">
            <input type="hidden" name="mail" value="<?=$_SESSION['umail']?>">
            <input type="hidden" name="uid" value="<?=$_SESSION['user_id']?>">
            <!-- <input type="hidden" name="unombre" value="<?=$_SESSION['unombre']?>">
            <input type="hidden" name="ufolio" value="<?=$_SESSION['ufolio']?>"> -->
            <input type="submit" value="Enviar Ahora" class="btn btn-form">
        </div>
    </form>
</div>