<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\View;

// Cargar datos
$presskitData = json_decode(file_get_contents(__DIR__ . '/../storage/data/presskit.json'), true);

$view = new View([
    'presskit' => $presskitData,
    'title' => 'Música - RITO STEREO',
    'description' => 'Escucha nuestros covers y versiones de los clásicos de Soda Stereo. Playlist en Spotify y videos en YouTube.'
]);

$content = $view->render('header') . 
           $view->section('music') . 
           $view->render('footer');

echo $view->layout('layout', $content);
