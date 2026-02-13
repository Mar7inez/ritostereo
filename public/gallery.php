<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\View;

// Cargar datos de galería
$galleryData = json_decode(file_get_contents(__DIR__ . '/../storage/data/gallery.json'), true);
$presskitData = json_decode(file_get_contents(__DIR__ . '/../storage/data/presskit.json'), true);

$view = new View([
    'gallery' => $galleryData,
    'presskit' => $presskitData,
    'title' => 'RITO STEREO - Galería | Fotos y Videos de Shows en Vivo',
    'description' => 'Revive los mejores momentos de RITO STEREO. Galería de fotos, videos y backstage de nuestros shows homenaje a Soda Stereo.'
]);

$content = $view->render('header') . 
           $view->section('gallery') . 
           $view->render('footer');

echo $view->layout('layout', $content);
