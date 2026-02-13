<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno si el archivo .env existe
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} else {
    // Valores por defecto si no hay .env
    $_ENV['APP_NAME'] = 'RITO STEREO';
    $_ENV['APP_URL'] = 'https://olive-jellyfish-784892.hostingersite.com';
    $_ENV['APP_ENV'] = 'production';
    $_ENV['APP_DEBUG'] = 'false';
    $_ENV['CACHE_DURATION'] = '3600';
}

session_start();

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/Mailer.php';
require_once __DIR__ . '/View.php';
require_once __DIR__ . '/Cache.php';
require_once __DIR__ . '/DataLoader.php';
require_once __DIR__ . '/ImageOptimizer.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/PerformanceMonitor.php';

// Inicializar sistemas
App\Cache::init();
App\ImageOptimizer::init();
App\PerformanceMonitor::init();
