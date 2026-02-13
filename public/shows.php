<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\View;

// Cargar datos
$presskitData = json_decode(file_get_contents(__DIR__ . '/../storage/data/presskit.json'), true);

$view = new View([
    'presskit' => $presskitData,
    'title' => 'Próximos Shows - RITO STEREO',
    'description' => 'Consulta todas las fechas de nuestros próximos shows. RITO STEREO en vivo en tu ciudad.'
]);

$content = $view->render('header') . 
           $view->section('shows') . 
           $view->render('footer');

echo $view->layout('layout', $content);
