<?
session_start();

$mensaje = 0;
if ( !empty($_POST)) {
    define("URL_SERVIDOR", dirname(__FILE__));
    include_once(URL_SERVIDOR . '/class/generales.php');
    
    $generales = new generales();

    include_once( URL_SERVIDOR . "/class/usuario.php" );
    $usuario = new usuario();
    $data = array();
    $data['mail'] = $_POST['mail'];
    $data['pass'] = $_POST['pass'];

    if ($response = $usuario->login( $data )) {
        $_SESSION['unombre'] = $response[0]["nombre"];
        $_SESSION['user_id'] = $response[0]["id"];
        $_SESSION['umail'] = $response[0]["correo"];
        $_SESSION['ufolio'] = $response[0]["folio"];
        $_SESSION['auth'] = 1;

        header('Location: index.php');
        exit;

    }else{
        $mensaje = 1;
    }

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de usuarios</title>

    <link rel="stylesheet" href="./libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="./css/user.css">
</head>
<body>
    <?
    if (!empty($_GET['q']) && $_GET['q'] == 'registro') {
        include_once( URL_SERVIDOR . '/register.php');
    }else{
    ?>
    <div class="login vh-100 vw-100 d-flex justify-content-center align-items-center" style="background: url('./img/bg-main.jpg') no-repeat center; background-size: cover;">
        <div class="container">
            <div class="row ">
                <div class="login-form offset-md-3 col-md-6 offset-lg-4 col-lg-4 card shadow rounded-3 py-4 px-3">
                    <p class="text-center"><img src="https://creditofinanciera.mx/img/lgoos%20web%20-03.png" alt="Credito Financiera Mexicna" class="img-fluid" width="200"></p>
                    <form action="login.php" method="POST" id="login">
                        <div class="input-group mb-3">
                            <label for="mail">
                                <i class="bi bi-envelope-fill fs-4 px-2"></i>
                            </label>
                            <input type="email" name="mail" id="mail" placeholder="Correo" class="form-control" />
                        </div>
                        <div class="input-group mb-4">
                            <label for="folio">
                                <i class="bi bi-lock fs-4 px-2"></i>
                            </label>
                            <input type="password" name="pass" id="folio" placeholder="Contraseña" class="form-control" />
                        </div>
                        <?
                        if ($mensaje == 1) {
                            echo '<p class="error mb-0">Correo o contrase&ntilde;a incorrectos</p>';
                        }
                        ?>
                        <p class="text-center"><small>¿Aun no tienes una cuenta? <a href="index.php?q=registro" class="fw-bold">Registrate</a></small></p>
                        <div class="input-group text-center justify-content-center">
                            <input type="submit" value="Iniciar sesión" class="btn btn-form" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?
    }
    ?>

    <script src="./libs/jquery/jquery-3.6.0.min.js"></script>
    <script src="./libs/jquery-validate/dist/jquery.validate.min.js"></script>
    <script src="./libs/jquery-validate/dist/additional-methods.min.js"></script>
    <script src="./js/validate.js"></script>
</body>
</html>