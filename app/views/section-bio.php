<section id="bio" class="py-20 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">Sobre RITO STEREO</h2>
                <p class="text-xl text-gray-300">
                    Conoce más sobre nuestro Homenaje
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Texto -->
                <div>
                    <div class="prose prose-lg prose-invert max-w-none">
                        <p class="text-gray-300 leading-relaxed mb-6">
                            <?= sanitizeString($presskit['bio_short']) ?>
                        </p>
                        
                        <p class="text-gray-300 leading-relaxed mb-8">
                        RITO STEREO es un homenaje que celebra la obra de Soda Stereo y Gustavo Cerati con una fidelidad sonora excepcional y una puesta visual inmersiva.
Nuestro show propone un viaje curado por eras, con arreglos cuidadosamente reconstruidos y una estética contemporánea que reinterpreta la esencia original desde una mirada actual.

Cada presentación combina los himnos más icónicos con visuales envolventes, atmósferas lumínicas y texturas inspiradas en toda la obra de Soda Stereo y Gustavo Cerati.

RITO STEREO no busca imitar, sino revivir la experiencia que marcó generaciones: el pulso del rock latino en su máxima expresión, con respeto, emoción y una mirada moderna que conecta pasado, presente y futuro.
                        </p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#contact" class="bg-rito-red hover:bg-rito-red-dark text-white px-8 py-3 rounded-2xl font-semibold transition-all duration-300 text-center">
                            Contactar para Contrataciones
                        </a>
                        <a href="#shows" class="border-2 border-rito-red text-rito-red hover:bg-rito-red hover:text-white px-8 py-3 rounded-2xl font-semibold transition-all duration-300 text-center">
                            Ver Próximos Shows
                        </a>
                    </div>
                </div>
                
                <!-- Imagen placeholder -->
                <div class="relative">
                    <div class="aspect-square bg-gradient-to-br from-rito-red/20 to-rito-red-dark/20 rounded-2xl flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-6xl font-bold text-rito-red mb-4">RITO</div>
                            <div class="text-6xl font-bold text-white">STEREO</div>
                        </div>
                    </div>
                    <!-- Replace with actual band photo -->
                    <!-- <img src="<?= asset('assets/img/logo-main.svg') ?>" alt="RITO STEREO en vivo" class="w-full h-full object-cover rounded-2xl"> -->
                </div>
            </div>
        </div>
    </div>
</section>
