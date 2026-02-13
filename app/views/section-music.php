<section id="music" class="py-20 bg-rito-black">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">Música</h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Escucha nuestros covers y versiones de los clásicos de Soda Stereo
            </p>
        </div>
        
        <!-- SoundCloud Player -->
        <?php if (is_subsection_enabled('music', 'soundcloud') && !empty($presskit['soundcloud_tracks'])): ?>
        <div class="mb-16">
            <h3 class="text-2xl font-bold mb-8 text-center text-white">Escucha en SoundCloud</h3>
            <div class="max-w-4xl mx-auto">
                <?php foreach ($presskit['soundcloud_tracks'] as $track): ?>
                <div class="mb-8 bg-gray-900 rounded-2xl p-6 hover:bg-gray-800 transition-colors duration-300">
                    <h4 class="text-white font-semibold mb-4 text-center"><?= sanitizeString($track['title']) ?></h4>
                    <div class="rounded-lg overflow-hidden">
                        <?= $track['embed_code'] ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Spotify Playlist -->
        <?php if (is_subsection_enabled('music', 'spotify') && !empty($presskit['spotify_playlist'])): ?>
        <div class="mb-16">
            <h3 class="text-2xl font-bold mb-8 text-center text-white">Playlist en Spotify</h3>
            <div class="max-w-2xl mx-auto">
            <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/76iQ4GhIkHOUOTsSRWWGe6?utm_source=generator&theme=0" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- YouTube Videos -->
        <?php if (is_subsection_enabled('music', 'youtube') && !empty($presskit['youtube_videos'])): ?>
        <div>
            <h3 class="text-2xl font-bold mb-8 text-center text-white">Videos en YouTube</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($presskit['youtube_videos'] as $video_id): ?>
                <div class="bg-gray-900 rounded-2xl overflow-hidden hover:scale-105 transition-transform duration-300">
                    <div class="aspect-video">
                        <iframe 
                            src="https://www.youtube.com/embed/<?= sanitizeString($video_id) ?>?rel=0&modestbranding=1" 
                            title="<?= sanitizeString(get_youtube_video_title($video_id)) ?>"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="w-full h-full">
                        </iframe>
                    </div>
                    <div class="p-4">
                        <h4 class="text-white font-semibold"><?= sanitizeString(get_youtube_video_title($video_id)) ?></h4>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Fallback si no hay videos -->
        <?php if (empty($presskit['youtube_videos']) && empty($presskit['spotify_playlist'])): ?>
        <div class="text-center py-12">
            <p class="text-gray-400 text-xl">Contenido musical próximamente.</p>
            <p class="text-gray-500 mt-2">¡Síguenos en nuestras redes para estar al día!</p>
        </div>
        <?php endif; ?>
    </div>
</section>
