<?
if ($_SESSION['apermiso'] == 3) {
    if (!empty($_POST) && $_GET['g'] == 'true') {

        if ($ejecutivo = $admin->registra_ejecutivo($_POST)) {
            switch ($ejecutivo) {
                case 1:
                    $message = '<div class="alert alert-primary" role="alert">
                Registro exitoso. Espere un momento...
                <script>setTimeout( function() { window.location.href = "index.php?q=ejecutivos"; }, 3000 );</script>
            </div>';
                    break;
                case 3:
                    $message = '<div class="alert alert-danger" role="alert">
                Este correo ya existe. Por favor introduce uno diferente.
            </div>';
                    break;
            }
        } else {
            $message = '<div class="alert alert-danger" role="alert">
                Hubo un error. Por favor <a href="index.php?q=ejecutivos_nuevo">intente de nuevo</a>
            </div>';
        }
    }
?>

    <div class="d-flex justify-content-center align-items-center">
        <div class="login-form col-md-6 card shadow rounded-3 py-4 px-3">
            <h3 class="mb-3">Registrar nuevo ejecutivo</h3>
            <?= $message ?>
            <form action="index.php?q=ejecutivos_nuevo&g=true" method="post" id="ejecutivos">
                <div class="input-group mb-3">
                    <label for="name">
                        <i class="bi bi-person fs-4 px-2"></i>
                    </label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nombre" value="" />
                </div>
                <div class="input-group mb-3">
                    <label for="mail">
                        <i class="bi bi-envelope fs-4 px-2"></i>
                    </label>
                    <input type="email" name="mail" id="mail" placeholder="Correo" class="form-control" />
                </div>
                <div class="input-group mb-4">
                    <label for="pass">
                        <i class="bi bi-lock fs-4 px-2"></i>
                    </label>
                    <input type="password" name="pass" id="pass" placeholder="Contreseña" class="form-control" value="<?= $value = !empty($_POST) ? $_POST['pass'] : ''; ?>" />
                </div>
                <div class="input-group text-center justify-content-center">
                    <input type="submit" value="Registrar" class="btn btn-form" />
                </div>
            </form>
        </div>
    </div>
<?
} else {
    echo '<div class="text-center">
            <h2>P&aacute;gina no encontrada :(</h2>
            <p>Usuario no Autorizado</p>
        </div>';
}
?>