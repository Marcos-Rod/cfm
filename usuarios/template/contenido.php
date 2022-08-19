<?
include_once(URL_SERVIDOR . "/class/usuario.php");
$user = new usuario;

if (!$status = $user->consulta_status($_SESSION['umail'])) {
    session_destroy();
    header('Location: index.php');
}
?>
<div class="contenido my-5 pb-4">
    <div class="container">
        <div class="row">

            <?
            if ($status[0]['estatus'] == '0' && $_POST != "") {
                if (file_exists(URL_SERVIDOR . "/template/forms/" . strtolower($url_form) . ".php")) {
                    include_once(URL_SERVIDOR  . "/template/forms/" . strtolower($url_form) . ".php");
                } else {
                    echo '<div class="text-center">
                            <h2>P&aacute;gina no encontrada :(</h2>
                            <p>Lo sentimos, esta p&aacute;gina no existe</p>
                        </div>';
                }
            } else {
                if (file_exists(URL_SERVIDOR . "/template/" . strtolower($url_seccion) . ".php")) {
                    include_once(URL_SERVIDOR  . "/template/" . strtolower($url_seccion) . ".php");
                } else {
                    echo '<div class="text-center">
                            <h2>P&aacute;gina no encontrada :(</h2>
                            <p>Lo sentimos, esta p&aacute;gina no existe</p>
                        </div>';
                }
            }
            ?>

        </div>
    </div>
</div>