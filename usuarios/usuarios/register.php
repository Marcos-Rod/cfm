<?
if (!empty($_POST && strlen($_POST['mail']) > 5 && strlen($_POST['name']) > 4)) {
    include_once(URL_SERVIDOR . '/class/usuario.php');
    $user = new usuario();

    if ($folio = $user->create($_POST)) {
        if ($folio === 3) {
            $message = '<div class="alert alert-danger" role="alert">
                Este correo ya existe. Por favor introduce uno diferente.
            </div>';
        } else {
            $message = '<div class="alert alert-primary" role="alert">
                    Ha sido registrado con éxito. Tu folio es  <strong>' . $folio . '</strong>
                    
                </div>';
        }
    } else {
        $message = '<div class="alert alert-danger" role="alert">
                Hubo un error al registrarse. Por favor <a href="index.php?q=registro">intente nuevamente</a>
            </div>';
    }
}
?>

<div class="login vh-100 vw-100 d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row ">
            <div class="login-form offset-md-3 col-md-6 offset-lg-4 col-lg-4 card shadow rounded-3 py-4 px-3">
                <p class="text-center"><img src="https://creditofinanciera.mx/img/lgoos%20web%20-03.png" alt="Credito Financiera Mexicna" class="img-fluid" width="200"></p>
                <?= $message ?>
                <form action="index.php?q=registro" method="post" id="register">
                    <div class="input-group mb-3">
                        <label for="name">
                            <i class="bi bi-person-fill fs-4 px-2"></i>
                        </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nombre" />
                    </div>
                    <div class="input-group mb-3">
                        <label for="mail">
                            <i class="bi bi-envelope-fill fs-4 px-2"></i>
                        </label>
                        <input type="email" name="mail" id="mail" placeholder="Correo" class="form-control" />
                    </div>
                    <div class="input-group mb-4">
                        <label for="phone">
                            <i class="bi bi-whatsapp fs-4 px-2"></i>
                        </label>
                        <input type="tel" name="phone" id="phone" placeholder="WhatsApp" class="form-control" />
                    </div>
                    <p class="text-center"><small>puebla? <a href="index.php" class="fw-bold">Inicia sesión</a></small></p>
                    <div class="input-group text-center justify-content-center">
                        <input type="submit" value="Registrar" class="btn btn-form" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
