
<?php

require $_SERVER['DOCUMENT_ROOT'] .'/tfg/Documentacion/PHPMailer/PHPMailerAutoload.php';

class Mail {

    private $mail;

	public function __construct(){
        $mail = new PHPMailer;
        
        //Configuracion
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'tfgplatform@gmail.com';            // SMTP username
        $mail->Password = 'tfg145678platform';                // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;
        $mail->isHTML(true);

	}

    /* Origen y destinos */
    public function setAdress($origen,$destinos){

        $mail->setFrom($origen->getEmail(),$origen->getNombreCompleto());

        foreach ($destinos as $destino) {
            $mail->addAddress($destino->getEmail(), $destino->getNombreCompleto());
        }
        
        //Otras opciones
        /*$mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');*/
    }

    /* Archivos */
    public function setArchivo($rutaArchivo){
        $mail->addAttachment($rutaArchivo);
    }

    /* Cuerpo del mensaje */
    public function setMensaje($asunto,$mensaje){
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    }

    /* Enviar mensaje */
    public function enviar(){
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    /*CRUD*/

    /* Crear */
    public static function crear($origen,$destinos,$asunto,$mensaje){
        $mail = new Mail();
        $mail->setAdress($origen,$destinos);
        $mail->setMensaje($asunto,$mensaje);
        $mail->enviar();
    }
}

?>