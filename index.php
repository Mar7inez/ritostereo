<?php

require_once __DIR__ . '/app/bootstrap.php';

use App\View;

// Cargar datos directamente (método original que funcionaba)
$presskitData = json_decode(file_get_contents(__DIR__ . '/storage/data/presskit.json'), true);
$galleryData = json_decode(file_get_contents(__DIR__ . '/storage/data/gallery.json'), true);
$showsData = json_decode(file_get_contents(__DIR__ . '/storage/data/shows.json'), true);

$view = new View([
    'presskit' => $presskitData,
    'gallery' => $galleryData,
    'shows' => $showsData['shows'] ?? [],
    'title' => 'RITO STEREO - Homenaje a Soda Stereo | Shows en Vivo',
    'description' => 'RITO STEREO es un Homenaje no oficial que honra la obra de Soda Stereo y Gustavo Cerati. Próximos shows, música y booking disponible.'
]);

$content = $view->render('header');

// Renderizar secciones según configuración
if (is_section_enabled('hero')) {
    $content .= $view->render('hero');
}

if (is_section_enabled('shows')) {
    $content .= $view->section('shows');
}

if (is_section_enabled('music')) {
    $content .= $view->section('music');
}

if (is_section_enabled('gallery')) {
    $content .= $view->section('gallery');
}

if (is_section_enabled('bio')) {
    $content .= $view->section('bio');
}

if (is_section_enabled('contact')) {
    $content .= $view->section('contact');
}

$content .= $view->render('footer');

echo $view->layout('layout', $content);
