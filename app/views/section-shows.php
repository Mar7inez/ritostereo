<?php
use App\Security;

// Carga de shows
$shows = get_shows_from_sheet();

// Carga opcional de tickets.json (id -> imagen)
$ticketsMap = [];
$ticketsJsonPath = __DIR__ . '/../storage/data/tickets.json';
if (is_file($ticketsJsonPath)) {
  $tData = json_decode(file_get_contents($ticketsJsonPath), true);
  if (!empty($tData['tickets'])) {
    foreach ($tData['tickets'] as $t) {
      if (!empty($t['id']) && !empty($t['imagen'])) {
        $ticketsMap[$t['id']] = $t['imagen'];
      }
    }
  }
}

// Resolver imagen del ticket
$resolveTicketImg = function(array $s) use ($ticketsMap) {
  if (!empty($s['imagen'])) return basename($s['imagen']);
  if (!empty($s['id']) && isset($ticketsMap[$s['id']])) return basename($ticketsMap[$s['id']]);
  return null;
};
?>
<section id="shows" class="py-20 bg-gray-900">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
      <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">Próximos Shows</h2>
      <p class="text-xl text-gray-300 max-w-2xl mx-auto">
        No te pierdas nuestras presentaciones en vivo. Experimenta la música de Soda Stereo como nunca antes.
      </p>
    </div>

    <?php if (empty($shows)): ?>
      <div class="text-center py-12">
        <p class="text-gray-400 text-xl opacity-80">Muy pronto anunciaremos nuevas fechas.</p>
        <p class="text-gray-500 mt-2">¡Mantente atento a nuestras redes para futuras fechas!</p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <?php $i = 0; foreach ($shows as $s): $i++; ?>
          <?php
            $ticketImg = $resolveTicketImg($s) ?: 'ticket_banner_con_dibujo.webp'; // fallback
            $mapQuery  = urlencode(trim(($s['lugar'] ?? '').' '.($s['ciudad'] ?? '').' Argentina'));
            $mapLink   = "https://www.google.com/maps/search/?api=1&query={$mapQuery}";
            $mapEmbed  = "https://www.google.com/maps?q={$mapQuery}&output=embed";
            $mapId     = "map-{$i}";
          ?>
          <!-- TICKET -->
          <article class="group relative block rounded-2xl p-[1px] bg-gradient-to-br from-rito-red/40 via-rito-red/20 to-transparent hover:from-rito-red/70 hover:via-rito-red/40 transition">
            <div class="relative grid grid-cols-[1fr_auto] items-stretch rounded-2xl bg-rito-black overflow-hidden min-h-[320px]">

              <!-- Brillo -->
              <span class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500"
                    style="background: linear-gradient(120deg,transparent 0%, rgba(255,255,255,.08) 30%, transparent 60%); mix-blend: screen;"></span>

              <!-- LADO IZQUIERDO -->
              <div class="relative p-0">

                <!-- HEADER DE IMAGEN más alto -->
                <div class="relative h-52 w-full overflow-hidden bg-neutral-900">
                  <img
                    src="<?= asset('assets/img/tickets/' . $ticketImg) ?>"
                    alt="Ticket <?= htmlspecialchars(($s['ciudad'] ?? '') . ' - ' . ($s['lugar'] ?? '')) ?>"
                    loading="lazy"
                    class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105" />
                  <div class="absolute inset-0 pointer-events-none"
                       style="background:
                         radial-gradient(60% 80% at 50% 10%, rgba(255,255,255,.07), transparent 60%),
                         linear-gradient(to bottom, rgba(0,0,0,.0) 55%, rgba(0,0,0,.35) 100%);">
                  </div>
                </div>

                <!-- CONTENIDO -->
                <div class="p-6">
                  <h3 class="text-lg font-semibold text-white">
                    <?= htmlspecialchars($s['ciudad'] ?? '') ?> · <?= htmlspecialchars($s['lugar'] ?? '') ?>
                  </h3>
                  <p class="opacity-80 text-gray-300">
                    <?= isset($s['fecha']) ? formatDate($s['fecha']) : '' ?> · <?= htmlspecialchars($s['hora'] ?? '') ?>
                  </p>

                  <?php if (!empty($s['precio'])): ?>
                    <p class="mt-1 text-sm uppercase tracking-wide text-rito-red">
                      <?= htmlspecialchars($s['precio']) ?>
                    </p>
                  <?php endif; ?>

                  <?php if (!empty($s['descripcion'])): ?>
                    <p class="mt-2 text-sm text-gray-400">
                      <?= htmlspecialchars($s['descripcion']) ?>
                    </p>
                  <?php endif; ?>

                  <!-- CTA + MAPA -->
                  <div class="mt-4 flex items-center gap-3 flex-wrap">
                    <?php if (!empty($s['entradas'])): ?>
                      <a class="inline-flex items-center gap-2 rounded-full border border-rito-red text-rito-red px-4 py-2 text-sm font-medium hover:bg-rito-red hover:text-white transition-all duration-300"
                         href="<?= htmlspecialchars($s['entradas']) ?>" target="_blank" rel="noopener">
                        Comprar Entradas
                        <svg class="w-4 h-4 transition transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                          <path d="M5 12h14M13 5l7 7-7 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </a>
                    <?php else: ?>
                      <span class="text-sm opacity-70 text-gray-400">Próximamente</span>
                    <?php endif; ?>

                    <button type="button"
                            class="px-3 py-2 text-sm rounded-full border border-white/10 text-gray-200 hover:bg-white/10 transition"
                            onclick="window.toggleMap('<?= $mapId ?>')">
                      Ver mapa
                    </button>

                    <a href="<?= $mapLink ?>" target="_blank" rel="noopener"
                       class="px-3 py-2 text-sm rounded-full border border-rito-red text-rito-red hover:bg-rito-red hover:text-white transition">
                      Cómo llegar
                    </a>
                  </div>

                  <!-- MAPA -->
                  <div id="<?= $mapId ?>" class="hidden mt-4 rounded-xl overflow-hidden border border-white/10 bg-black/30">
                    <div class="relative w-full" style="padding-bottom:56.25%;">
                      <iframe class="absolute inset-0 w-full h-full"
                              data-src="<?= $mapEmbed ?>" loading="lazy"
                              referrerpolicy="no-referrer-when-downgrade"
                              style="border:0; filter:contrast(1.05) saturate(1.05)"></iframe>
                    </div>
                  </div>
                </div>
              </div>

              <!-- LADO DERECHO: troquel + barras más ancho -->
              <div class="relative w-20 lg:w-24 grid place-items-center pl-3 pr-2">
                <div class="absolute left-0 top-3 bottom-3 border-l-2 border-dashed border-gray-700"></div>
                <span class="absolute -left-3 top-2 w-6 h-6 rounded-full bg-rito-black"></span>
                <span class="absolute -left-3 bottom-2 w-6 h-6 rounded-full bg-rito-black"></span>
                <div class="h-24 w-12 lg:w-14 rotate-90"
                     style="background: repeating-linear-gradient(90deg,#fff 0 2px,transparent 2px 4px); opacity:.9;"></div>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <p class="mt-10 text-center text-xs text-gray-500">
      Show tributo no oficial. Obra y marcas pertenecen a sus titulares. Se respeta la legislación vigente y la gestión de derechos de ejecución pública.
    </p>
  </div>
</section>

<style>
/* Hover motion para ticket */
#shows .group:hover .rounded-2xl{
  transform: translateY(-6px) rotate(-.5deg);
  box-shadow: 0 25px 60px rgba(0,0,0,.5);
  transition: transform .35s ease, box-shadow .35s ease;
}
</style>

<script>
/* Toggle mapa + lazy load del iframe */
window.toggleMap = function(id){
  var box = document.getElementById(id);
  if(!box) return;
  box.classList.toggle('hidden');
  var iframe = box.querySelector('iframe[data-src]');
  if(iframe && !iframe.src){ iframe.src = iframe.dataset.src; }
};
</script>
