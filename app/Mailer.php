<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mailer;
    
    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->configure();
    }
    
    private function configure()
    {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = config('MAIL_HOST');
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = config('MAIL_USER');
            $this->mailer->Password = config('MAIL_PASS');
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = config('MAIL_PORT', 587);
            $this->mailer->CharSet = 'UTF-8';
            
            $this->mailer->setFrom(config('MAIL_FROM'), config('MAIL_FROM_NAME'));
            $this->mailer->addAddress(config('MAIL_TO', 'ritostereo@gmail.com'));
            
        } catch (Exception $e) {
            logError('Error configurando PHPMailer: ' . $e->getMessage());
        }
    }
    
    public function sendContactMessage($data)
    {
        try {
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Nuevo mensaje de contacto - ' . $data['subject'];
            
            $body = $this->buildContactEmailBody($data);
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            
            $this->mailer->send();
            return ['success' => true, 'message' => 'Mensaje enviado correctamente'];
            
        } catch (Exception $e) {
            $error = 'Error enviando email: ' . $e->getMessage();
            logError($error, $data);
            return ['success' => false, 'message' => 'Error al enviar el mensaje. Inténtalo más tarde.'];
        }
    }
    
    private function buildContactEmailBody($data)
    {
        return "
        <h2>Nuevo mensaje de contacto desde RITO STEREO</h2>
        <p><strong>Nombre:</strong> " . sanitizeString($data['name']) . "</p>
        <p><strong>Email:</strong> " . sanitizeString($data['email']) . "</p>
        <p><strong>Asunto:</strong> " . sanitizeString($data['subject']) . "</p>
        <p><strong>Mensaje:</strong></p>
        <p>" . nl2br(sanitizeString($data['message'])) . "</p>
        <hr>
        <p><small>Enviado el " . date('d/m/Y H:i:s') . " desde " . config('APP_URL') . "</small></p>
        ";
    }
}
