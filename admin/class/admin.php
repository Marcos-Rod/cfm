<?
include_once(URL_SERVIDOR . '/class/db.php');
include_once(URL_SERVIDOR . '/class/generales.php');
include_once(URL_SERVIDOR . '/class/mail.php');

class admin
{
    function __construct()
    {
        $this->db = new db();
        $this->generales = new generales();
        $this->mail = new mail();
    }

    public function login($request = "")
    {
        if (!is_array($request) || empty($request['mail']) || empty($request['password']))
            return false;

        if (!$password = $this->comprueba_pwd($request['password'], $request['mail']))
            return false;

        $sql = sprintf(
            "SELECT
                    a.id,
                    a.nombre,
                    a.correo,
                    a.password,
                    a.permisos
                FROM
                    admins AS a
                WHERE
                    a.correo = '%s'
                ",
            $this->db->db_limpia_cadena_sql($request['mail'])
        );

        if (!$response = $this->db->db_query($sql, 1))
            return false;

        return $response;
    }

    public function comprueba_pwd($password = '', $mail)
    {
        $sql_select = sprintf(
            "SELECT 
                    password
                FROM
                    admins 
                WHERE
                    correo = '%s'",
            $mail
        );

        if (!$array = $this->db->db_query($sql_select, 1))
            return false;

        $hash = $array[0]['password'];
        $pass = trim($password);

        $verify = password_verify($pass, $hash);

        if ($verify)
            return true;
        else
            return false;
    }
    public function lista_usuarios()
    {
        $sql = sprintf("SELECT 
            u.id,
            u.nombre,
            u.correo,
            u.telefono,
            u.folio,
            u.estatus,
            u.admin_id,
            a.nombre as ejecutivo_asignado
        FROM 
            users AS u
        LEFT JOIN admins AS a ON u.admin_id = a.id
        ORDER BY
            u.id ASC
        ");

        if (!$response = $this->db->db_query($sql, 1))
            return false;

        for ($i = 0; $i < count($response); $i++) {
            $response[$i]['folio'] = str_pad($response[$i]['folio'], 5, '0', STR_PAD_LEFT);
        }

        return $response;
    }

    public function lista_usuarios_ejecutivo_id($id)
    {
        $sql = sprintf(
            "SELECT 
            u.id,
            u.nombre,
            u.correo,
            u.telefono,
            u.folio,
            u.estatus,
            u.admin_id
        FROM 
            users AS u
        WHERE
            u.admin_id = %d
        ORDER BY
            u.id ASC
        ",
            intval($id)
        );

        if (!$response = $this->db->db_query($sql, 1))
            return false;

        for ($i = 0; $i < count($response); $i++) {
            $response[$i]['folio'] = str_pad($response[$i]['folio'], 5, '0', STR_PAD_LEFT);
        }

        return $response;
    }

    public function lista_usuarios_id($id)
    {
        $sql = sprintf(
            "SELECT 
            u.id,
            u.nombre,
            u.correo,
            u.telefono,
            u.folio,
            u.estatus,
            u.admin_id,
            info.datos_generales,
            info.documentacion
        FROM 
            users AS u
        LEFT JOIN datos_user AS info ON u.id = info.user_id
        WHERE
            u.id = %d
        ORDER BY
            u.id ASC
        ",
            intval($id)
        );

        if (!$response = $this->db->db_query($sql, 1))
            return false;

        for ($i = 0; $i < count($response); $i++) {
            $response[$i]['folio'] = str_pad($response[$i]['folio'], 5, '0', STR_PAD_LEFT);
        }

        return $response;
    }

    public function edita_usuario($request, $old_files, $files, $data_user)
    {
        if (!is_array($request))
            return false;

        $contFile = 0;
        $newFiles = array();
        $keyFiles = array_keys($files);

        $dir = '../credito/files/'. $data_user['folio'];
        
        foreach ($files as $file) {
            $aleatorio = md5(uniqid(rand(), true));
            $strUnica = substr($aleatorio, 0, 5);

            if (empty($file['name'])) {
                $newFiles[$keyFiles[$contFile]] = $old_files[$keyFiles[$contFile]];
            }else{
                $newFiles[$keyFiles[$contFile]] = $strUnica . '-' . $file['name'];
                move_uploaded_file($file['tmp_name'], $dir . '/'. $newFiles[$keyFiles[$contFile]]);
            }

            
            $contFile ++;
        }
        $sql = sprintf(
            "UPDATE datos_user 
                SET 
                    datos_generales = '%s',
                    documentacion = '%s',
                    update_at = '%s'
                WHERE
                    user_id = %d",
            json_encode($request),
            json_encode($newFiles),
            $this->generales->hoy(),
            intval($data_user['id'])
        );

        if (!$response = $this->db->db_query($sql, 3))
            return false;


        return true;
    }

    public function registra_ejecutivo($request)
    {
        if (!is_array($request) || empty($request['name']) || empty($request['mail'] || empty($request['pass'])))
            return false;

        $sql_select = sprintf(
            " SELECT
                correo 
            FROM
                admins 
            WHERE
                correo = '%s'",
            $request['mail']
        );

        if ($arr_select = $this->db->db_query($sql_select, 1))
            return $existe = 3;

        if (!$password = $this->generales->pwd_generate($request['pass']))
            return false;

        $sql = sprintf(
            "INSERT INTO
                admins (nombre, correo, password, permisos, create_at)
            VALUES
                ('%s', '%s', '%s', '%d', '%s')
        ",
            $this->db->db_limpia_cadena_sql($request['name']),
            $this->db->db_limpia_cadena_sql($request['mail']),
            $password,
            1,
            $this->generales->hoy()
        );

        if (!$response = $this->db->db_query($sql, 2))
            return false;

        return true;
    }
    public function lista_ejecutivos()
    {
        $sql = sprintf("SELECT 
            a.id,
            a.nombre,
            a.correo
        FROM 
            admins AS a
        WHERE
            a.estatus != 1
        ORDER BY
            a.id ASC
        ");

        if (!$response = $this->db->db_query($sql, 1))
            return false;

        return $response;
    }
    public function asignar($request)
    {
        if (!is_array($request))
            return false;

        $sql = sprintf(
            "UPDATE users 
            SET 
                estatus = '%d',
                admin_id = '%d'
            WHERE
                id = '%d'",
            2,
            $this->db->db_limpia_cadena_sql($request['ejecutivo']),
            $request['user_id']
        );

        if (!$response = $this->db->db_query($sql, 3))
            return false;

        return true;
    }
    public function eliminar_ejecutivo($id)
    {

        $sql = sprintf(
            "UPDATE admins 
            SET 
                estatus = 1
            WHERE
                id = %d",
            intval($id)
        );

        if (!$response = $this->db->db_query($sql, 3))
            return false;

        return true;
    }
    public function status_aprobado($request)
    {
        $arr_mail = array();
        $arr_mail['mail_remitente_nombre'] = $_SESSION['anombre'];
        $arr_mail['mail_remitente_correo'] = $_SESSION['amail'];
        $arr_mail['mail_asunto'] = 'Registro exitoso';
        $arr_mail['mail_destinatario_nombre'] = $request['nombre'];
        $arr_mail['mail_destinatario_correo'] = $request['correo'];
        $arr_mail['mail_body'] = '<p>La solicitud de su crédito ha sido revisada y aprobada. Por favor continue su proceso en el siguiente enlace</p>
        <p><a href="https://creditofinanciera.mx/credito/index.php?q=gracias">Click aquí</a></p>';

        if (!$this->mail->enviar_mail($arr_mail))
            return false;

        $sql = sprintf(
            "UPDATE users 
            SET 
                estatus = 3
            WHERE
                id = %d",
            intval($request['id'])
        );

        if (!$response = $this->db->db_query($sql, 3))
            return false;

        return true;
    }
    public function notificar($request){
        $arr_mail = array();
        $arr_mail['mail_remitente_nombre'] = $_SESSION['anombre'];
        $arr_mail['mail_remitente_correo'] = $_SESSION['amail'];
        $arr_mail['mail_asunto'] = 'Solicitud de crédito';
        $arr_mail['mail_destinatario_nombre'] = $request['nombre'];
        $arr_mail['mail_destinatario_correo'] = $request['correo'];
        $arr_mail['mail_body'] = $request['mensaje'];

        if (!$this->mail->enviar_mail($arr_mail))
            return false;

        return true;
    }
}
