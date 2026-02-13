<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\View;

http_response_code(404);

$view = new View([
    'title' => 'Página no encontrada - RITO STEREO',
    'description' => 'La página que buscas no existe. Regresa al inicio de RITO STEREO.'
]);

$content = $view->render('header') . 
           '<section class="min-h-screen flex items-center justify-center bg-rito-black">
                <div class="text-center px-4">
                    <h1 class="text-6xl md:text-8xl font-bold text-rito-red mb-4">404</h1>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">Página no encontrada</h2>
                    <p class="text-gray-300 mb-8 max-w-md mx-auto">
                        La página que buscas no existe o ha sido movida.
                    </p>
                    <a href="' . url() . '" class="bg-rito-red hover:bg-rito-red-dark text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 inline-block">
                        Volver al Inicio
                    </a>
                </div>
            </section>' . 
           $view->render('footer');

echo $view->layout('layout', $content);
