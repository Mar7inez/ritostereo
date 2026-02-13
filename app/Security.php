<?php

namespace App;

class Security
{
    public static function csrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCsrf($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function isBot($honeypot)
    {
        return !empty($honeypot);
    }

    public static function rateLimit($ip, $maxAttempts = 20, $timeWindow = 300)
    {
        $key = "rate_limit_$ip";
        $now = time();
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'first_attempt' => $now];
        }
        
        $data = $_SESSION[$key];
        
        if ($now - $data['first_attempt'] > $timeWindow) {
            $_SESSION[$key] = ['count' => 1, 'first_attempt' => $now];
            return true;
        }
        
        if ($data['count'] >= $maxAttempts) {
            return false;
        }
        
        $_SESSION[$key]['count']++;
        return true;
    }

    public static function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }
        
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function validateContactForm($data)
    {
        $errors = [];
        
        if (empty($data['name']) || strlen($data['name']) < 2) {
            $errors[] = 'El nombre es requerido y debe tener al menos 2 caracteres';
        }
        
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email es requerido y debe ser válido';
        }
        
        if (empty($data['subject']) || strlen($data['subject']) < 5) {
            $errors[] = 'El asunto es requerido y debe tener al menos 5 caracteres';
        }
        
        if (empty($data['message']) || strlen($data['message']) < 10) {
            $errors[] = 'El mensaje es requerido y debe tener al menos 10 caracteres';
        }
        
        return $errors;
    }
    
    public static function validateMathCaptcha($question, $answer)
    {
        if (empty($question) || empty($answer)) {
            return false;
        }

        // Usar los números de la sesión para validar
        if (isset($_SESSION['captcha_num1']) && isset($_SESSION['captcha_num2'])) {
            $num1 = (int)$_SESSION['captcha_num1'];
            $num2 = (int)$_SESSION['captcha_num2'];
            $expectedAnswer = $num1 + $num2;
            $userAnswer = (int)$answer;
            
            // Limpiar la sesión después de validar
            unset($_SESSION['captcha_num1']);
            unset($_SESSION['captcha_num2']);
            
            return $userAnswer === $expectedAnswer;
        }

        return false;
    }
}
