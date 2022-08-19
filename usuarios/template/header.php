<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de usuario</title>

    <link rel="stylesheet" href="./libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="./libs/aos-master/dist/aos.css">
    <link rel="stylesheet" href="./css/user.css">

    <?
        $url_form = strtolower($_GET["f"]);
        if (empty($_GET["f"]) && !isset($_GET['q'])) {
            $url_form = "tipo_credito";
        }
        
        $url_seccion = strtolower($_GET["q"]);
        if (empty($_GET["q"]) || isset($_GET["q"])) {
            $url_seccion = "gracias";
        }
        
    ?>
</head>

<body>
    <header>
        <div class="header py-2">
            <div class="container">
                <div class="row">
                    <div class=" d-flex justify-content-between align-items-center">
                        <img src="https://creditofinanciera.mx/img/lgoos%20web%20-03.png" alt="Credito Financiera Mexicna" class="img-fluid" width="150">
                        <div>
                            <a href="logout.php"><i class="bi bi-box-arrow-left"></i> Salir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>