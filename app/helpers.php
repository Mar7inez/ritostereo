<?php

function config(string $key, mixed $default = null): mixed {
    return $_ENV[$key] ?? $default;
}

function asset(string $path): string {
    return '/' . ltrim($path, '/');
}

function url(string $path = ''): string {
    $baseUrl = config('APP_URL', 'http://localhost');
    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
}

function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

function formatTime($time) {
    return date('H:i', strtotime($time));
}

function sanitizeString($string) {
    return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
}

function sanitizeEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function logError($message, $context = []) {
    $logFile = __DIR__ . '/../storage/logs/log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
    $logMessage = "[$timestamp] $message$contextStr" . PHP_EOL;
    
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

function get_sheet_json_cached($cacheFile = null) {
    if ($cacheFile === null) {
        $cacheFile = __DIR__ . '/../storage/data/shows.cache.json';
    }
    
    $sheetUrl = config('SHEET_JSON_URL');
    $cacheTtl = (int) config('SHEET_CACHE_TTL', 900); // 15 minutos por defecto
    
    // Verificar si el cache existe y es válido
    if (file_exists($cacheFile)) {
        $cacheData = json_decode(file_get_contents($cacheFile), true);
        $cacheTime = $cacheData['cached_at'] ?? 0;
        
        if ((time() - $cacheTime) < $cacheTtl) {
            return $cacheData['data'] ?? [];
        }
    }
    
    // Intentar obtener datos frescos de Google Sheets
    if (!empty($sheetUrl)) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'RITO STEREO Website/1.0'
            ]
        ]);
        
        $jsonData = @file_get_contents($sheetUrl, false, $context);
        
        if ($jsonData !== false) {
            $data = json_decode($jsonData, true);
            
            if ($data && isset($data['items'])) {
                // Guardar en cache
                $cacheData = [
                    'cached_at' => time(),
                    'data' => $data
                ];
                
                file_put_contents($cacheFile, json_encode($cacheData), LOCK_EX);
                return $data;
            }
        }
        
        logError('Error obteniendo datos de Google Sheets', ['url' => $sheetUrl]);
    }
    
    // Fallback: usar cache viejo si existe
    if (file_exists($cacheFile)) {
        $cacheData = json_decode(file_get_contents($cacheFile), true);
        return $cacheData['data'] ?? [];
    }
    
    // Último recurso: array vacío
    return ['items' => []];
}

function get_shows_from_sheet() {
    // Usar datos locales si no hay Google Sheets configurado
    $localFile = __DIR__ . '/../storage/data/shows.json';
    
    if (file_exists($localFile)) {
        $data = json_decode(file_get_contents($localFile), true);
        $shows = $data['shows'] ?? [];
        
        // Ordenar por fecha
        usort($shows, function($a, $b) {
            return strcmp($a['fecha'], $b['fecha']);
        });
        
        return $shows;
    }
    
    // Fallback: usar Google Sheets si está configurado
    $payload = get_sheet_json_cached();
    $items = $payload['items'] ?? [];
    
    // Filtrar items válidos
    $valid = array_values(array_filter($items, function($item) {
        return !empty($item['date']) && !empty($item['city']) && !empty($item['venue']);
    }));
    
    // Ordenar por fecha
    usort($valid, function($a, $b) {
        return strcmp($a['date'], $b['date']);
    });
    
    return $valid;
}

function get_youtube_video_title($video_id) {
    // Títulos predefinidos que SÍ funcionan
    $titles = [
        'dQw4w9WgXcQ' => 'Never Gonna Give You Up - Rick Astley',
        'jNQXAC9IVRw' => 'Me at the zoo - Jawed Karim', 
        'fJ9rUzIMcZQ' => 'Bohemian Rhapsody - Queen',
        '9bZkp7q19f0' => 'GANGNAM STYLE - PSY',
        'YQHsXMglC9A' => 'Hello - Adele',
        'kJQP7kiw5Fk' => 'Despacito - Luis Fonsi ft. Daddy Yankee'
    ];
    
    return $titles[$video_id] ?? "Video de RITO STEREO";
}

function get_soundcloud_embed_url($track_url, $options = []) {
    $defaults = [
        'color' => 'D72638', // Color rojo de RITO STEREO
        'auto_play' => 'false',
        'hide_related' => 'false',
        'show_comments' => 'true',
        'show_user' => 'true',
        'show_reposts' => 'false',
        'show_teaser' => 'true'
    ];
    
    $params = array_merge($defaults, $options);
    $query_string = http_build_query($params);
    
    return "https://w.soundcloud.com/player/?url=" . urlencode($track_url) . "&" . $query_string;
}

function optimized_image($imagePath, $width = null, $height = null, $alt = '', $class = '') {
    return \App\ImageOptimizer::generatePictureElement($imagePath, $alt, $width, $height, $class);
}

function image_url($imagePath, $width = null, $height = null) {
    return \App\ImageOptimizer::getOptimizedImage($imagePath, $width, $height);
}

function webp_image($imagePath, $width = null, $height = null) {
    return \App\ImageOptimizer::getWebpImage($imagePath, $width, $height);
}

function preload_critical_resources() {
    $criticalImages = [
        'assets/img/logo-main.svg',
        'assets/img/logo-v.svg'
    ];
    
    $preloads = [];
    foreach ($criticalImages as $image) {
        $preloads[] = '<link rel="preload" as="image" href="' . asset($image) . '">';
    }
    
    return implode("\n    ", $preloads);
}

function get_performance_metrics() {
    $startTime = $_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true);
    $endTime = microtime(true);
    $executionTime = round(($endTime - $startTime) * 1000, 2);
    
    $memoryUsage = round(memory_get_usage(true) / 1024 / 1024, 2);
    $peakMemory = round(memory_get_peak_usage(true) / 1024 / 1024, 2);
    
    return [
        'execution_time' => $executionTime . 'ms',
        'memory_usage' => $memoryUsage . 'MB',
        'peak_memory' => $peakMemory . 'MB'
    ];
}

function get_sections_config() {
    static $sectionsConfig = null;
    
    if ($sectionsConfig === null) {
        $configFile = __DIR__ . '/../storage/data/sections.json';
        if (file_exists($configFile)) {
            $sectionsConfig = json_decode(file_get_contents($configFile), true);
        } else {
            // Configuración por defecto si no existe el archivo
            $sectionsConfig = [
                'hero' => ['enabled' => true],
                'shows' => ['enabled' => true],
                'music' => ['enabled' => true, 'subsections' => ['soundcloud' => ['enabled' => true], 'spotify' => ['enabled' => false], 'youtube' => ['enabled' => false]]],
                'gallery' => ['enabled' => true],
                'bio' => ['enabled' => true],
                'contact' => ['enabled' => true]
            ];
        }
    }
    
    return $sectionsConfig;
}

function is_section_enabled($sectionName) {
    $config = get_sections_config();
    return isset($config[$sectionName]) && $config[$sectionName]['enabled'] === true;
}

function is_subsection_enabled($sectionName, $subsectionName) {
    $config = get_sections_config();
    return isset($config[$sectionName]['subsections'][$subsectionName]) && 
           $config[$sectionName]['subsections'][$subsectionName]['enabled'] === true;
}

function update_section_config($sectionName, $enabled, $subsectionName = null) {
    $configFile = __DIR__ . '/../storage/data/sections.json';
    $config = get_sections_config();
    
    if ($subsectionName) {
        if (!isset($config[$sectionName]['subsections'])) {
            $config[$sectionName]['subsections'] = [];
        }
        $config[$sectionName]['subsections'][$subsectionName]['enabled'] = $enabled;
    } else {
        $config[$sectionName]['enabled'] = $enabled;
    }
    
    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
}
