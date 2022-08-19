<?
include_once(URL_SERVIDOR . '/class/db.php');
include_once(URL_SERVIDOR . '/class/generales.php');
include_once(URL_SERVIDOR . '/class/mail.php');

class usuario
{
    public $user = "";
    protected $password = "";
    public $folio = "";

    function __construct()
    {
        $this->db = new db();
        $this->generales = new generales();
        $this->mail = new mail();
    }

    public function create($request)
    {
        if (!is_array($request) || empty($request["mail"]) || empty($request['pass']))
            return false;

        $sql_select = sprintf(
            " SELECT 
                    correo 
                FROM
                    users 
                WHERE
                    correo = '%s'",
            $request['mail']
        );

        if ($arr_select = $this->db->db_query($sql_select, 1))
            return 'existente';

        $folio = $this->crea_folio();
        $password = password_hash($request['pass'], PASSWORD_DEFAULT);

        $sql = sprintf(
            "INSERT INTO
                    users (nombre, correo, telefono, folio, pass, estatus, create_at)
                VALUES
                    ('%s', '%s', '%s', '%d', '%s', '%d', '%s')
                ",
            $this->db->db_limpia_cadena_sql($request['name']),
            $this->db->db_limpia_cadena_sql($request['mail']),
            $this->db->db_limpia_cadena_sql($request['phone']),
            $folio,
            $password,
            0,
            $this->generales->hoy()
        );


        if (!$response = $this->db->db_query($sql, 2))
            return false;

        return $response;
    }

    public function crea_folio()
    {
        $cont = "";

        $sql = sprintf("SELECT MAX(folio) as folio FROM users");
        if (!$response = $this->db->db_query($sql, 1))
            return false;

        $last_folio = array_values($response[0]);
        if ($last_folio[0] == "") {
            $new_folio = str_pad(101, 5, '0', STR_PAD_LEFT);
        } else {
            $last_folio = intval($last_folio[0]);

            $new_folio = $last_folio++;
            $new_folio = str_pad($last_folio, 5, '0', STR_PAD_LEFT);
        }


        return $new_folio;
    }

    public function comprueba_pwd($password = '', $mail)
    {
        $sql_select = sprintf(
            " SELECT 
                    pass 
                FROM
                    users 
                WHERE
                    correo = '%s'",
            $mail
        );

        if (!$array = $this->db->db_query($sql_select, 1))
            return false;

        $hash = $array[0]['pass'];
        $pass = strval($password);

        $verify = password_verify($pass, $hash);

        if ($verify)
            return true;
        else
            return false;
    }

    public function login($request = "")
    {
        if (!is_array($request) || empty($request['mail']) || empty($request['pass']))
            return false;

        if (!$password = $this->comprueba_pwd($request['pass'], $request['mail']))
            return false;

        $sql = sprintf(
            "SELECT
                u.id,
                u.nombre,
                u.correo,
                u.telefono,
                u.folio,
                u.pass
            FROM
                users AS u
            WHERE
                u.correo = '%s'
            ",
            $this->db->db_limpia_cadena_sql($request['mail'])
        );

        if (!$response = $this->db->db_query($sql, 1))
            return false;

        return $response;
    }

    //Guarda todos los documentos en el servidor y envia correo
    public function procesar_datos($request = "", $files = array())
    {
        if (!is_array($request) || !is_array($files))
            return false;

        $folio = str_pad($_SESSION['ufolio'], 5, '0', STR_PAD_LEFT);
        $dir = URL_SERVIDOR . "/files/" . $folio . "";
        $array_files = array_keys($files);

        if (!is_dir($dir))
            mkdir($dir, 0777, true);

        foreach ($array_files as $item) {
            if ($files[$item]['type'] != 'application/pdf') {
                echo $files[$item]['type'];
                return false;
            }
        }

        $links_documentos = array();
        foreach ($array_files as $item) {

            $aleatorio = md5(uniqid(rand(), true));
            $strUnica = substr($aleatorio, 0, 5);
            $nombre_archivo = $strUnica . '-' . $files[$item]['name'];

            move_uploaded_file($files[$item]['tmp_name'], $dir . '/'. $nombre_archivo);

            $links_documentos[$item] = $nombre_archivo;
        }

        //Array limpio para guardar en su columna en base de datos
        $datos_form = array_merge($request);
        unset($datos_form['uid']);
        unset($datos_form['mail']);

        $datos_files = array_combine($array_files, $links_documentos);

        //Guarda todos los datos en la Base de datos
        $sql_guardar = sprintf(
            "INSERT INTO
                datos_user (user_id, datos_generales, documentacion, create_at)
            VALUES
                ('%d', '%s', '%s', '%s')",
            $this->db->db_limpia_cadena_sql($request['uid']),
            json_encode($datos_form, JSON_UNESCAPED_UNICODE),
            json_encode($datos_files),
            $this->generales->hoy()
        );

        if (!$response = $this->db->db_query($sql_guardar, 2))
        return false;

        $sql = sprintf(
            "UPDATE users SET estatus = '%d'
            WHERE correo = '%s'",
            1,
            $request['mail']
        );
        
        if (!$response = $this->db->db_query($sql, 3))
        return false;

        
        if (!$this->enviar_mail($request, $links_documentos))
            return $respose = 4;
        

        return true;
    }

    public function enviar_mail($datos, $request_files = array())
    {
        $array_name = array_keys($request_files);
        for ($i = 0; $i < count($array_name); $i++) {
            $nombre_archivos = str_replace('_', ' ', $array_name[$i]);
            $nombre_archivo[] = ucwords($nombre_archivos) . '</br>';
        }
        
        if (!$this->mail->mail_envia_admin($datos, $request_files, $nombre_archivo))
        return false;
        
        return true;
    }

    public function consulta_status($mail = ""){
        if (empty($mail))
            return false;

        $sql = sprintf(
            "SELECT
                u.id,
                u.estatus
            FROM
                users AS u
            WHERE
                u.correo = '%s'
            ",
            $_SESSION['umail']
        );

        if (!$response = $this->db->db_query($sql, 1))
            return false;

        return $response;
    }
}
