<?

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
        $this->mail->setFrom($datos['mail_remitente_correo'], utf8_decode($datos['mail_remitente_nombre']));     // Remitente del correo

        // Destinatarios
        $this->mail->addAddress($datos['mail_destinatario_correo'], utf8_decode($datos['mail_destinatario_nombre']));  // Email y nombre del destinatario

        // Contenido del correo
        $this->mail->isHTML(true);
        $this->mail->Subject = utf8_decode($datos['mail_asunto']);
        $this->mail->Body  = '<table align="center" width="600">
                                <tr>
                                    <td style="text-align:center;background:#fff;padding:10px 0;border-bottom:2px solid #ededed;">
                                        <a href="http://creditofinanciera.mx/" class="logo"><img src="https://creditofinanciera.mx/img/lgoos%20web%20-03.png" alt="" id="cambioLogo" width="150"/></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <p>&nbsp;</p>
                                        ' . $datos['mail_body'] . '
                                        <p>&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-top:2px solid #ededed;padding-top:10px;">
                                        <p style="text-align:center;"><a href="https://www.sharpempresas.mx">www.creditofinanciera.mx</a></p>
                                    </td>
                                </tr>
                            </table>';
        /* $this->mail->AltBody = 'Los datos que dejó fueron los siguientes. Nombre: ' . $datos['nombre'] . ', Teléfono: ' . $datos['telefono'] . ', Correo: ' . $datos['correo'] . ', Comentarios: ' . $datos['comentarios']; */
        /* return false; */

        if (!$this->mail->send())
            return false;

        return true;
    }
}
