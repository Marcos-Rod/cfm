<?
include_once(URL_SERVIDOR . '/class/generales.php');
$generales = new generales();

include_once(URL_SERVIDOR . '/class/admin.php');
$admin = new admin();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Administrador</title>

    <link rel="stylesheet" href="./libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <!-- 
    <link rel="stylesheet" href="./libs/aos-master/dist/aos.css"> -->
    <link rel="stylesheet" type="text/css" href="./libs/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="./css/user.css">

    <?
    $url_seccion =  strtolower($_GET["q"]);
    if (empty($_GET["q"]))
        $url_seccion = "inicio";
    ?>
</head>

<body>
    <header>
        <div class="header py-2">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-md-10">
                        <nav class="navbar navbar-expand-lg navbar-light py-0">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="#">
                                    <img src="https://creditofinanciera.mx/img/lgoos%20web%20-03.png" alt="Credito Financiera Mexicna" class="img-fluid" width="150">
                                </a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                    <ul class="navbar-nav px-4">
                                        <li class="nav-item">
                                            <a class="nav-link <?= $value = $_GET['q'] == 'inicio' || empty($_GET['q']) || $_GET['q'] == 'usuario_detalle' ? 'active' : ''; ?>" aria-current="page" href="index.php">Usuarios</a>
                                        </li>
                                        <?
                                        if($_SESSION['apermiso'] == 3){
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $value = $_GET['q'] == 'ejecutivos' || $_GET['q'] == 'ejecutivos_nuevo' ? 'active' : ''; ?>" href="index.php?q=ejecutivos">Ejecutivos</a>
                                        </li>
                                        <?}?>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="logout.php"><i class="bi bi-box-arrow-left"></i> Salir</a>
                    </div>
                </div>
            </div>
        </div>

    </header>