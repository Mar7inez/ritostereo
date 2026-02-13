<!-- HEADER RITO STEREO -->
<header x-data="headerCtrl()" 
        @scroll.window="onScroll()" 
        class="fixed top-0 left-0 right-0 z-50 transition-colors duration-300 border-b"
        :class="scrolled ? 'bg-rito-black/95 backdrop-blur-sm border-gray-800' : 'bg-rito-black/80 backdrop-blur-sm border-gray-800/60'">

  <nav class="container mx-auto px-4 py-3">
    <div class="flex items-center justify-between">
      <!-- Logo / Marca -->
      <div class="flex items-center gap-3">
        <img src="<?= asset('assets/img/favicon.svg') ?>" alt="RITO STEREO" class="w-8 h-8 md:w-10 md:h-10">
        <a href="<?= url() ?>" class="text-xl md:text-2xl font-bold text-white hover:text-rito-red transition-colors">
          RITO <span class="text-rito-red">STEREO</span>
        </a>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center gap-8">
        <?php if (is_section_enabled('shows')): ?>
          <a href="#shows" :class="linkClass('shows')">Shows</a>
        <?php endif; ?>
        <?php if (is_section_enabled('music')): ?>
          <a href="#music" :class="linkClass('music')">Música</a>
        <?php endif; ?>
        <?php if (is_section_enabled('gallery')): ?>
          <a href="#gallery" :class="linkClass('gallery')">Galería</a>
        <?php endif; ?>
        <?php if (is_section_enabled('bio')): ?>
          <a href="#bio" :class="linkClass('bio')">Bio</a>
        <?php endif; ?>
        <?php if (is_section_enabled('contact')): ?>
          <a href="#contact" :class="linkClass('contact')">Contacto</a>
        <?php endif; ?>
      </div>

      <!-- Mobile Menu Button -->
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white p-2" aria-label="Abrir menú">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden mt-3 pb-4 border-t border-gray-800">
      <div class="flex flex-col pt-3">
        <?php if (is_section_enabled('shows')): ?>
          <a href="#shows" @click="closeMobile()" :class="linkClass('shows', true)">Shows</a>
        <?php endif; ?>
        <?php if (is_section_enabled('music')): ?>
          <a href="#music" @click="closeMobile()" :class="linkClass('music', true)">Música</a>
        <?php endif; ?>
        <?php if (is_section_enabled('gallery')): ?>
          <a href="#gallery" @click="closeMobile()" :class="linkClass('gallery', true)">Galería</a>
        <?php endif; ?>
        <?php if (is_section_enabled('bio')): ?>
          <a href="#bio" @click="closeMobile()" :class="linkClass('bio', true)">Bio</a>
        <?php endif; ?>
        <?php if (is_section_enabled('contact')): ?>
          <a href="#contact" @click="closeMobile()" :class="linkClass('contact', true)">Contacto</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>

<!-- Alpine controller (puede ir al final del <body>) -->
<script>
  function headerCtrl(){
    return {
      scrolled: false,
      mobileMenuOpen: false,
      active: null, // 'shows' | 'music' | 'bio' | 'contact'
      onScroll(){
        this.scrolled = window.scrollY > 50;
      },
      closeMobile(){ this.mobileMenuOpen = false; },
      linkClass(id, mobile=false){
        const base = mobile 
          ? 'py-2 text-gray-300 hover:text-white transition-colors'
          : 'text-gray-300 hover:text-white transition-colors nav-hover';
        const active = this.active === id ? ' text-white nav-active' : '';
        return base + active;
      },
      init(){
        // Scrollspy sencillo con IntersectionObserver
        // Solo observar secciones habilitadas
        const enabledSections = <?= json_encode(array_keys(array_filter([
          'shows' => is_section_enabled('shows'),
          'music' => is_section_enabled('music'),
          'gallery' => is_section_enabled('gallery'),
          'bio' => is_section_enabled('bio'),
          'contact' => is_section_enabled('contact')
        ]))) ?>;
        
        const io = new IntersectionObserver(entries => {
          entries.forEach(e => { if(e.isIntersecting){ this.active = e.target.id; }});
        }, { rootMargin: '-40% 0px -60% 0px', threshold: 0 });
        
        enabledSections.forEach(id => {
          const el = document.getElementById(id);
          if(el) io.observe(el);
        });
        this.onScroll();
      }
    }
  }
</script>

<!-- Estilos mínimos para glow/activo -->
<style>
  .nav-hover:hover {
    text-shadow: 0 0 8px rgba(215, 38, 56, 0.65);
  }
  .nav-active {
    text-shadow: 0 0 10px rgba(215, 38, 56, 0.8), 0 0 18px rgba(215, 38, 56, 0.35);
    position: relative;
  }
  .nav-active::after{
    content:'';
    position:absolute; left:0; right:0; bottom:-8px; margin:auto;
    width: 18px; height: 2px; border-radius: 9999px;
    background: #d72638;
    box-shadow: 0 0 8px rgba(215, 38, 56, 0.7);
  }
  @media (prefers-reduced-motion: reduce){
    .nav-hover:hover, .nav-active { text-shadow:none; }
  }
</style>
