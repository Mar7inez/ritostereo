<footer class="bg-gray-900 py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Redes Sociales -->
            <div>
                <h3 class="text-xl font-bold mb-4 text-rito-red">Síguenos</h3>
                <div class="flex space-x-4">
                    <?php if (!empty($presskit['social']['instagram'])): ?>
                    <a href="<?= $presskit['social']['instagram'] ?>" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($presskit['social']['youtube'])): ?>
                    <a href="<?= $presskit['social']['youtube'] ?>" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($presskit['social']['spotify'])): ?>
                    <a href="<?= $presskit['social']['spotify'] ?>" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 8.88 15 9.42 18.72 11.7c.361.181.54.78.241 1.021zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Enlaces -->
            <div>
                <h3 class="text-xl font-bold mb-4 text-rito-red">Enlaces</h3>
                <div class="flex flex-col space-y-2">
                    <a href="#shows" class="text-gray-400 hover:text-white transition-colors duration-300">Próximos Shows</a>
                    <a href="#music" class="text-gray-400 hover:text-white transition-colors duration-300">Música</a>
                    <a href="#bio" class="text-gray-400 hover:text-white transition-colors duration-300">Biografía</a>
                    <a href="#contact" class="text-gray-400 hover:text-white transition-colors duration-300">Contacto</a>
                </div>
            </div>
            
            <!-- Disclaimer Legal -->
            <div>
                <h3 class="text-xl font-bold mb-4 text-rito-red">Legal</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Show homenaje no oficial. Obra y marcas pertenecen a sus titulares. 
                    Se respeta la legislación vigente y la gestión de derechos de ejecución pública.
                </p>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-gray-400 text-sm">
                © <?= date('Y') ?> RITO STEREO. Todos los derechos reservados.
            </p>
        </div>
    </div>
</footer>
