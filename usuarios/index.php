<?
session_start();

/* ini_set('display_errors', 'on');
ini_set('log_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('error_reporting', E_ALL); */

define("URL_SERVIDOR", dirname(__FILE__));

if (isset($_SESSION['auth']) == 1 && intval($_SESSION["user_id"]) > 0) {
    include_once(URL_SERVIDOR . '/template/header.php');
    include_once(URL_SERVIDOR . '/template/contenido.php');
    include_once(URL_SERVIDOR . '/template/footer.php');
} else {
    session_destroy();
        include_once( URL_SERVIDOR . '/login.php');
}
