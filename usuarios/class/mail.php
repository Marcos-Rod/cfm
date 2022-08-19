<?
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

include_once(URL_SERVIDOR . '/class/generales.php');

//Lib PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require URL_SERVIDOR . '/libs/PHPMailer/src/Exception.php';
require URL_SERVIDOR . '/libs/PHPMailer/src/PHPMailer.php';
require URL_SERVIDOR . '/libs/PHPMailer/src/SMTP.php';

class mail
{
    function __construct()
    {
        $this->mail = new PHPMailer();
        $this->generales = new generales();
    }

    function enviar_mail($datos = "")
    {
        if (!is_array($datos)) {
            return false;
        }


        // Configuracion SMTP
        /* $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; */                         // Mostrar salida (Desactivar en producción)
        $this->mail->isSMTP();                                               // Activar envio SMTP
        $this->mail->Host  = '';                     // Servidor SMTP
        $this->mail->SMTPAuth  = true;                                       // Identificacion SMTP
        $this->mail->Username  = '';                  // Usuario SMTP
        $this->mail->Password  = '';              // Contraseña SMTP
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port  = 465;
        $this->mail->setFrom('contacto@creditofinanciera.mx', utf8_decode('Crédito Financiera Mexicana'));                // Remitente del correo

        // Destinatarios
        $this->mail->addAddress($datos['destinatario_correo'], utf8_decode($datos['destinatario_nombre']));  // Email y nombre del destinatario

        // Contenido del correo
        $this->mail->isHTML(true);
        $this->mail->Subject = utf8_decode($datos['asunto']);
        $this->mail->Body  = $datos['cuerpo'];
        /* $this->mail->AltBody = 'Los datos que dejó fueron los siguientes. Nombre: ' . $datos['nombre'] . ', Teléfono: ' . $datos['telefono'] . ', Correo: ' . $datos['correo'] . ', Comentarios: ' . $datos['comentarios']; */
        /* return false; */

        if (!$this->mail->send())
            return false;

        return true;
    }

    public function mail_envia_admin($datos_inputs, $datos, $nombre_documentos)
    {
        $arr_datos = array();

        unset($datos_inputs['uid']);
        unset($datos_inputs['mail']);

        $folio = str_pad($_SESSION['ufolio'], 5, '0', STR_PAD_LEFT);

        $cuerpo = '
        <table align="center" width="600">
            <tr>
                <td style="text-align:center;background:#fff;padding:10px 0;border-bottom:2px solid #ededed;">
                    <a href="http://creditofinanciera.mx/" class="logo"><img src="https://creditofinanciera.mx/img/lgoos%20web%20-03.png" alt="" id="cambioLogo" width="150"/></a>
                </td>
            </tr>
            <tr>
                <td>
                    <p>&nbsp;</p>
                    <h1 style="text-align:center;"><strong>Un usuario quiere solicitar su crédito</strong></h1>
                    <h4 style="text-align:center;"><strong>Los datos que dejó fueron los siguientes:</strong></h4>
                    
                    <p><strong>Datos: </strong></p>
                    <ul>';

        $nombres_label = $this->generales->keys_to_works($datos_inputs);

        $cont_label = 0;
        foreach ($datos_inputs as $item) {
            $cuerpo .= '
                <li>
                    <strong>' . $nombres_label[$cont_label] . '<strong>: ' . $item . '
                </li>
                ';
            $cont_label++;
        }


        $cuerpo .= '          </ul>
                    <p><strong>Documentación: </strong></p>
                    <ul>';

        $cont = 0;

        foreach ($datos as $item) {
            $cuerpo .= '

                <li>
                    <strong>' . $nombre_documentos[$cont] . '</strong>: <a href="https://www.' . $_SERVER['HTTP_HOST'] . '/credito/files/' . $folio . '/' . $item . '">' . $item . '</a>
                </li>

                ';
            $cont++;
        }

        $cuerpo .= '          </ul>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td style="border-top:2px solid #ededed;padding-top:10px;">
                    <p style="text-align:center;"><a href="https://www.sharpempresas.mx">www.creditofinanciera.mx</a></p>
                </td>
            </tr>
        </table>
        ';
        
        $arr_datos['destinatario_correo'] = 'web@peperonidigital.mx';
        $arr_datos['destinatario_nombre'] = 'Crédito Financiera Mexicana';
        $arr_datos['asunto'] = 'Nueva solicitud de crédito';
        $arr_datos['cuerpo'] = $cuerpo;

        if(!$this->enviar_mail($arr_datos))
            return false;

        $cuerpo_usuario = '<table align="center" width="600">
            <tr>
                <td style="text-align:center;background:#fff;padding:10px 0;border-bottom:2px solid #ededed;">
                    <a href="http://creditofinanciera.mx/" class="logo"><img src="https://creditofinanciera.mx/img/lgoos%20web%20-03.png" alt="" id="cambioLogo" width="150"/></a>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">
                    <p>&nbsp;</p>
                        <h3>Su correo se envió con éxito</h3>
                        <p>Un ejecutivo revisarára sus datos y se pondrá en contacto con usted.</p>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td style="border-top:2px solid #ededed;padding-top:10px;">
                    <p style="text-align:center;"><a href="https://www.sharpempresas.mx">www.creditofinanciera.mx</a></p>
                </td>
            </tr>
        </table>
        ';
        
        
        $arr_datos_usuario = array();
        $arr_datos_usuario['destinatario_correo'] = $_SESSION['umail'];
        $arr_datos_usuario['destinatario_nombre'] = $_SESSION['nombre'];
        $arr_datos_usuario['asunto'] = 'Correo enviado con éxito';
        $arr_datos_usuario['cuerpo'] = $cuerpo_usuario;

        if(!$this->enviar_mail($arr_datos_usuario))
            return false;

        return true;
    }
}
