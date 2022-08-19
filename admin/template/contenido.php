<div class="contenido my-5 pb-5">
    <div class="container">
        <div class="row">
            <?
            if (file_exists(URL_SERVIDOR . "/template/secciones/" . strtolower($url_seccion) . ".php")) {
                include_once(URL_SERVIDOR  . "/template/secciones/" . strtolower($url_seccion) . ".php");
            } else {
                echo '<div class="text-center">
                        <h2>P&aacute;gina no encontrada :(</h2>
                        <p>Lo sentimos, esta p&aacute;gina no existe</p>
                    </div>';
            }
            ?>
        </div>
    </div>
</div>