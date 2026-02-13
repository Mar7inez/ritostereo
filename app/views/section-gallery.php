<!-- Gallery Section -->
<section id="gallery" class="min-h-screen bg-gradient-to-br from-rito-black via-gray-900 to-rito-black" 
         x-data="galleryApp()" 
         x-init="init()">
     
    <!-- Hero Header -->
    <div class="relative overflow-hidden py-16 px-4">
        <div class="absolute inset-0 bg-gradient-to-r from-rito-red/20 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto text-center">
            <h2 class="text-4xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                GALERÍA
            </h2>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto mb-8">
                Revive los mejores momentos de nuestros shows. Fotos, videos y backstage exclusivo.
            </p>
            <a href="gallery.php" 
               class="inline-flex items-center gap-2 bg-rito-red hover:bg-rito-red-dark text-white px-6 py-3 rounded-full font-medium transition-all duration-300 hover:scale-105">
                Ver Galería Completa
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Stories Highlights -->
    <div class="px-4 mb-12">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-white">Highlights</h2>
            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                <template x-for="highlight in highlights" :key="highlight.id">
                    <div class="flex-shrink-0 cursor-pointer group" @click="openStory(highlight)">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-rito-red to-pink-500 p-0.5 group-hover:scale-110 transition-transform duration-300">
                            <div class="w-full h-full rounded-full bg-rito-black p-0.5">
                                <img :src="highlight.image" 
                                     :alt="highlight.title"
                                     class="w-full h-full rounded-full object-cover"
                                     loading="lazy">
                            </div>
                        </div>
                        <p class="text-xs text-center mt-2 text-gray-300" x-text="highlight.title"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Preview Note -->
    <div class="px-4 mb-8">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-400 text-sm">
                Vista previa - <a href="gallery.php" class="text-rito-red hover:text-rito-red-dark underline">Ver galería completa con filtros</a>
            </p>
        </div>
    </div>

    <!-- Timeline Gallery Preview -->
    <div class="px-4 mb-16">
        <div class="max-w-7xl mx-auto">
            <template x-for="(event, index) in timeline.slice(0, 1)" :key="event.date">
                <div class="mb-16 opacity-0 animate-fade-in" x-intersect="$el.classList.add('animate-slide-up')">
                    <!-- Event Header -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center gap-4 bg-gray-800/50 backdrop-blur-sm rounded-full px-6 py-3">
                            <span class="text-rito-red font-bold" x-text="formatDate(event.date)"></span>
                            <span class="text-gray-400">•</span>
                            <span class="text-white font-medium" x-text="event.venue"></span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-300" x-text="event.city"></span>
                        </div>
                        <h3 class="text-3xl font-bold text-white mt-4" x-text="event.title"></h3>
                        
                        <!-- Mini Setlist -->
                        <div class="flex flex-wrap justify-center gap-2 mt-4">
                            <template x-for="song in event.setlist" :key="song">
                                <span class="bg-rito-red/20 text-rito-red px-3 py-1 rounded-full text-sm" x-text="song"></span>
                            </template>
                        </div>
                    </div>

                    <!-- Masonry Grid -->
                    <div class="masonry-grid" x-ref="masonryContainer">
                        <template x-for="media in event.media" :key="media.id">
                            <div class="masonry-item group cursor-pointer" 
                                 @click="openLightbox(media)"
                                 x-intersect="lazyLoad($el)">
                                
                                <!-- Ticket Effect Container -->
                                <div class="relative overflow-hidden rounded-lg bg-gray-800 ticket-hover">
                                    <!-- Media Content -->
                                    <div class="relative aspect-auto">
                                        <img :data-src="media.thumbnail" 
                                             :alt="media.caption"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 lazy-image"
                                             loading="lazy">
                                        
                                        <!-- Video Overlay -->
                                        <div x-show="media.type === 'video'" 
                                             class="absolute inset-0 flex items-center justify-center bg-black/30">
                                            <div class="w-16 h-16 bg-rito-red rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Backstage Badge -->
                                        <div x-show="media.type === 'backstage'" 
                                             class="absolute top-3 left-3 bg-purple-600 text-white px-2 py-1 rounded-full text-xs font-medium">
                                            🎭 Backstage
                                        </div>
                                    </div>

                                    <!-- Caption -->
                                    <div class="p-4">
                                        <p class="text-gray-300 text-sm" x-text="media.caption"></p>
                                    </div>

                                    <!-- Ticket Effect Overlay -->
                                    <div class="ticket-shine"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Fan Wall -->
    <div class="px-4 mb-16">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-white mb-4">Fan Wall</h2>
                <p class="text-gray-300 mb-6">Comparte tu experiencia con nosotros</p>
                <button @click="openFanForm()" 
                        class="bg-rito-red hover:bg-rito-red-dark text-white px-8 py-3 rounded-full font-medium transition-all duration-300 hover:scale-105">
                    📸 Subir tu foto
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="fan in fanWall" :key="fan.id">
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 hover:bg-gray-800/70 transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <img :src="fan.image" 
                                 :alt="fan.name"
                                 class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <h4 class="text-white font-medium" x-text="fan.name"></h4>
                                <p class="text-gray-400 text-sm" x-text="fan.city"></p>
                            </div>
                        </div>
                        <p class="text-gray-300 italic" x-text="fan.message"></p>
                        <p class="text-gray-500 text-xs mt-3" x-text="formatDate(fan.date)"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="lightbox.open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
         @click="closeLightbox()"
         @keydown.escape.window="closeLightbox()">
        
        <div class="relative max-w-4xl max-h-[90vh] mx-4" @click.stop>
            <!-- Close Button -->
            <button @click="closeLightbox()" 
                    class="absolute -top-12 right-0 text-white hover:text-rito-red transition-colors duration-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Media Content -->
            <div class="bg-gray-900 rounded-lg overflow-hidden">
                <template x-if="lightbox.media && lightbox.media.type === 'video'">
                    <video :src="lightbox.media.url" 
                           class="w-full max-h-[70vh] object-contain"
                           controls 
                           autoplay>
                    </video>
                </template>
                
                <template x-if="lightbox.media && lightbox.media.type !== 'video'">
                    <img :src="lightbox.media.url" 
                         :alt="lightbox.media.caption"
                         class="w-full max-h-[70vh] object-contain">
                </template>

                <!-- Caption -->
                <div class="p-6">
                    <p class="text-white text-lg" x-text="lightbox.media?.caption"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Story Modal -->
    <div x-show="story.open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/95"
         @click="closeStory()">
        
        <div class="relative w-full max-w-md h-full max-h-[80vh] mx-4" @click.stop>
            <!-- Progress Bar -->
            <div class="absolute top-4 left-4 right-4 flex gap-1 z-10">
                <template x-for="(item, index) in storyItems" :key="index">
                    <div class="flex-1 h-1 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full bg-white transition-all duration-300" 
                             :style="`width: ${story.currentIndex > index ? 100 : (story.currentIndex === index ? story.progress : 0)}%`"></div>
                    </div>
                </template>
            </div>

            <!-- Story Content -->
            <div class="w-full h-full bg-gray-900 rounded-lg overflow-hidden">
                <template x-if="story.current">
                    <img :src="story.current.image" 
                         :alt="story.current.title"
                         class="w-full h-full object-cover">
                </template>
                
                <!-- Story Title -->
                <div class="absolute bottom-6 left-6 right-6">
                    <h3 class="text-white text-xl font-bold" x-text="story.current?.title"></h3>
                </div>
            </div>

            <!-- Navigation -->
            <button @click="previousStory()" 
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white/70 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <button @click="nextStory()" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/70 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</section>

<style>
/* Masonry Grid */
.masonry-grid {
    column-count: 1;
    column-gap: 1rem;
    column-fill: balance;
}

@media (min-width: 640px) {
    .masonry-grid { column-count: 2; }
}

@media (min-width: 1024px) {
    .masonry-grid { column-count: 3; }
}

@media (min-width: 1280px) {
    .masonry-grid { column-count: 4; }
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 1rem;
    display: inline-block;
    width: 100%;
}

/* Ticket Effect */
.ticket-hover {
    position: relative;
    overflow: hidden;
    transform: perspective(1000px) rotateX(0deg) rotateY(0deg);
    transition: all 0.3s ease;
}

.ticket-hover:hover {
    transform: perspective(1000px) rotateX(-2deg) rotateY(1.5deg) scale(1.02);
    box-shadow: 0 20px 40px rgba(215, 38, 56, 0.3);
}

.ticket-shine {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%) translateY(-100%) rotate(45deg);
    transition: transform 0.6s ease;
}

.ticket-hover:hover .ticket-shine {
    transform: translateX(100%) translateY(100%) rotate(45deg);
}

/* Animations */
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slide-up {
    from { 
        opacity: 0;
        transform: translateY(30px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
}

.animate-slide-up {
    animation: slide-up 0.8s ease-out forwards;
}

/* Scrollbar Hide */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Lazy Loading */
.lazy-image {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.lazy-image.loaded {
    opacity: 1;
}
</style>

<script>
function galleryApp() {
    return {
        // Data
        highlights: <?= json_encode($gallery['highlights']) ?>,
        timeline: <?= json_encode($gallery['timeline']) ?>,
        fanWall: <?= json_encode($gallery['fan_wall']) ?>,
        filters: <?= json_encode($gallery['filters']) ?>,
        
        // State (simplified for index preview)
        activeFilter: {
            type: 'all',
            city: 'all',
            year: 'all'
        },
        
        lightbox: {
            open: false,
            media: null
        },
        
        story: {
            open: false,
            current: null,
            currentIndex: 0,
            progress: 0,
            timer: null
        },
        
        storyItems: [],

        // Computed (simplified for index preview)
        get filteredTimeline() {
            // For index preview, just return first event
            return this.timeline.slice(0, 1);
        },

        // Methods
        init() {
            // Initialize masonry and lazy loading
            this.$nextTick(() => {
                this.initLazyLoading();
            });
        },

        initLazyLoading() {
            const lazyImages = document.querySelectorAll('.lazy-image');
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));
        },

        lazyLoad(el) {
            const img = el.querySelector('.lazy-image');
            if (img && img.dataset.src) {
                img.src = img.dataset.src;
                img.classList.add('loaded');
            }
        },

        openLightbox(media) {
            this.lightbox.open = true;
            this.lightbox.media = media;
            document.body.style.overflow = 'hidden';
        },

        closeLightbox() {
            this.lightbox.open = false;
            this.lightbox.media = null;
            document.body.style.overflow = 'auto';
        },

        openStory(highlight) {
            this.storyItems = [highlight]; // En una implementación real, cargarías múltiples items
            this.story.open = true;
            this.story.currentIndex = 0;
            this.story.current = this.storyItems[0];
            this.startStoryTimer();
            document.body.style.overflow = 'hidden';
        },

        closeStory() {
            this.story.open = false;
            this.clearStoryTimer();
            document.body.style.overflow = 'auto';
        },

        nextStory() {
            if (this.story.currentIndex < this.storyItems.length - 1) {
                this.story.currentIndex++;
                this.story.current = this.storyItems[this.story.currentIndex];
                this.story.progress = 0;
                this.startStoryTimer();
            } else {
                this.closeStory();
            }
        },

        previousStory() {
            if (this.story.currentIndex > 0) {
                this.story.currentIndex--;
                this.story.current = this.storyItems[this.story.currentIndex];
                this.story.progress = 0;
                this.startStoryTimer();
            }
        },

        startStoryTimer() {
            this.clearStoryTimer();
            this.story.progress = 0;
            
            const duration = 5000; // 5 seconds
            const interval = 50; // Update every 50ms
            const increment = (interval / duration) * 100;
            
            this.story.timer = setInterval(() => {
                this.story.progress += increment;
                if (this.story.progress >= 100) {
                    this.nextStory();
                }
            }, interval);
        },

        clearStoryTimer() {
            if (this.story.timer) {
                clearInterval(this.story.timer);
                this.story.timer = null;
            }
        },

        openFanForm() {
            // En una implementación real, abriría un modal con formulario o redirigiría a Google Forms
            window.open('https://forms.google.com/your-form-id', '_blank');
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-AR', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }
    }
}
</script>
