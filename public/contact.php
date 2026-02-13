<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Security.php';
require_once __DIR__ . '/../app/Mailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

try {
    // Validar CSRF
    if (!isset($_POST['csrf_token']) || !App\Security::verifyCsrfToken($_POST['csrf_token'])) {
        http_response_code(403);
        $response['message'] = 'Token CSRF inválido.';
        echo json_encode($response);
        exit;
    }

    // Validar honeypot
    if (App\Security::isBot($_POST['website'] ?? '')) {
        $response['message'] = 'Solicitud detectada como spam';
        echo json_encode($response);
        exit;
    }

    // Validar captcha matemático
    $captchaQuestion = $_POST['captcha_question'] ?? '';
    $captchaAnswer = (int)($_POST['captcha_answer'] ?? 0);

    if (preg_match('/(\d+)\s*\+\s*(\d+)/', $captchaQuestion, $matches)) {
        $num1 = (int)$matches[1];
        $num2 = (int)$matches[2];
        $expectedAnswer = $num1 + $num2;
        
        if ($captchaAnswer !== $expectedAnswer) {
            $response['message'] = 'La respuesta al captcha es incorrecta';
            echo json_encode($response);
            exit;
        }
    } else {
        $response['message'] = 'Captcha inválido';
        echo json_encode($response);
        exit;
    }

    // Validar longitud del mensaje
    $message = $_POST['message'] ?? '';
    if (strlen($message) < 10) {
        $response['message'] = 'El mensaje debe tener al menos 10 caracteres';
        echo json_encode($response);
        exit;
    }

    // Rate limiting
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    if (!App\Security::rateLimit($ip, 10, 3600)) {
        $response['message'] = 'Demasiados intentos. Inténtalo más tarde.';
        echo json_encode($response);
        exit;
    }

    // Preparar datos
    $data = [
        'name' => App\Security::sanitizeInput($_POST['name'] ?? 'No name'),
        'email' => App\Security::sanitizeInput($_POST['email'] ?? 'No email'),
        'subject' => App\Security::sanitizeInput($_POST['subject'] ?? 'No subject'),
        'message' => App\Security::sanitizeInput($message),
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $ip
    ];

    // Intentar enviar email real
    try {
        $mailer = new App\Mailer();
        $mailer->sendContactMessage($data);
        
        $response['success'] = true;
        $response['message'] = '¡Mensaje enviado correctamente! Te contactaremos pronto.';
        
    } catch (Exception $e) {
        // Si falla el email, guardar en archivo como respaldo
        $logFile = __DIR__ . '/../storage/logs/contact-messages.txt';
        $logEntry = sprintf(
            "[%s] %s <%s> - %s\n%s\n--------------------------------------------------\n\n",
            $data['timestamp'],
            $data['name'],
            $data['email'],
            $data['subject'],
            $data['message']
        );
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        $response['success'] = true;
        $response['message'] = '¡Mensaje recibido! Te contactaremos pronto.';
    }

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error in contact.php: " . $e->getMessage());
    $response['message'] = 'Error interno del servidor. Inténtalo más tarde.';
    http_response_code(500);
    echo json_encode($response);
}
?>