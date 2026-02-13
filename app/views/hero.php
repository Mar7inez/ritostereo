<!-- HERO RITO STEREO con partículas (tsParticles) -->
<section class="hero-bg min-h-screen flex items-center justify-center relative overflow-hidden py-40">
  <!-- Background base -->
  <div class="absolute inset-0 z-0">
    <div class="w-full h-full bg-gradient-to-br from-rito-black via-gray-900 to-rito-black"></div>
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30"
         style="background-image: url('<?= asset('assets/img/hero-bg.jpg') ?>');"></div>

    <!-- Contenedor de partículas -->
    <div id="tsparticles-hero" class="absolute inset-0 w-full h-full pointer-events-none"></div>

    <!-- Viñeta suave -->
    <div class="absolute inset-0 pointer-events-none" style="box-shadow: inset 0 0 200px rgba(0,0,0,.6)"></div>
  </div>

  <!-- Overlay colilargos (DOBLE CAPA) -->
  <canvas id="sperm-back"  class="absolute inset-0 w-full h-full pointer-events-none z-[2]"></canvas>
  <canvas id="sperm-front" class="absolute inset-0 w-full h-full pointer-events-none z-[5]"></canvas>

  <!-- Contenido -->
  <div class="relative z-10 text-center px-4 max-w-4xl mx-auto hero-fade">
    <div class="mb-12">
      <img id="hero-logo" src="<?= asset('assets/img/logo-sin-fondo.png') ?>" alt="RITO STEREO"
           class="mx-auto mb-8 rounded-full w-64 h-64 md:w-80 md:h-80 neon-glow soft-shadow"
           loading="eager" decoding="async" fetchpriority="high">
    </div>

    <h1 id="hero-title" class="hero-title text-5xl md:text-7xl font-bold mb-6 text-white tracking-tight">
      RITO <span class="text-rito-red">STEREO</span>
    </h1>

    <p id="hero-tagline" class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed tracking-wide">
      <?= $presskit['tagline'] ?? 'Homenaje respetuoso y potente a Soda Stereo & Gustavo Cerati' ?>
    </p>

    <div id="hero-ctas" class="flex flex-col sm:flex-row gap-6 justify-center">
      <a href="#shows"
         class="px-8 py-3 rounded-2xl font-semibold text-white 
                bg-rito-red/90 hover:bg-rito-red 
                transition-all duration-300 focus:outline-none 
                focus:ring-2 focus:ring-rito-red/40 
                shadow-md hover:shadow-lg">
        Ver Próximas Fechas
      </a>
      <a href="#music"
         class="px-8 py-3 rounded-2xl font-semibold border-2 border-white/80 
                text-white hover:bg-white hover:text-rito-black 
                transition-all duration-300 focus:outline-none 
                focus:ring-2 focus:ring-white/40">
        Escuchar Música
      </a>
    </div>
  </div>

  <!-- Indicador scroll -->
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce text-white/70" aria-hidden="true">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
    </svg>
  </div>
</section>

<!-- Estilos mínimos -->
<style>
  .neon-glow{
    border-radius:9999px;
    box-shadow:0 0 22px rgba(215,38,56,.75),0 0 48px rgba(215,38,56,.45),0 0 90px rgba(215,38,56,.25);
    animation:glowPulse 4.5s ease-in-out infinite;
  }
  @keyframes glowPulse{
    0%,100%{box-shadow:0 0 22px rgba(215,38,56,.7),0 0 48px rgba(215,38,56,.4),0 0 90px rgba(215,38,56,.2)}
    50%{box-shadow:0 0 30px rgba(215,38,56,.85),0 0 60px rgba(215,38,56,.55),0 0 110px rgba(215,38,56,.3)}
  }
  .soft-shadow{filter:drop-shadow(0 10px 30px rgba(0,0,0,.35)) drop-shadow(0 2px 8px rgba(0,0,0,.35))}
  .hero-fade{opacity:0;transform:translateY(10px);animation:heroIn .8s ease-out forwards .15s}
  @keyframes heroIn{to{opacity:1;transform:translateY(0)}}
  .hero-title{display:inline-block;animation:subtleVibe 3s infinite ease-in-out}
  @keyframes subtleVibe{0%,100%{transform:translate(0,0) rotate(0)}10%{transform:translate(-.5px,.5px) rotate(-.2deg)}20%{transform:translate(.8px,-.4px) rotate(.2deg)}30%{transform:translate(-.4px,.8px) rotate(-.1deg)}40%{transform:translate(.6px,-.3px) rotate(.15deg)}50%{transform:translate(-.3px,.6px) rotate(-.15deg)}60%{transform:translate(.4px,-.2px) rotate(.1deg)}70%{transform:translate(-.2px,.4px) rotate(-.1deg)}80%{transform:translate(.2px,-.1px) rotate(.05deg)}90%{transform:translate(-.1px,.2px) rotate(-.05deg)}}
  @media (prefers-reduced-motion:reduce){.neon-glow{animation:none}.hero-fade{animation:none;opacity:1;transform:none}.hero-title{animation:none}}
</style>

<!-- tsParticles CDN -->
<script src="https://cdn.jsdelivr.net/npm/tsparticles@3/tsparticles.bundle.min.js"></script>
<script>
(async () => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  await tsParticles.load({
    id: "tsparticles-hero",
    options: {
      fullScreen:{enable:false}, detectRetina:true, background:{color:"transparent"},
      motion:{disable:reduce}, fpsLimit:60,
      particles:{
        number:{value:window.matchMedia('(max-width:768px)').matches?18:34, density:{enable:true, area:800}},
        color:{value:["#ffffff","#d72638"]},
        opacity:{value:0.22, random:{enable:true, minimumValue:0.12}},
        size:{value:{min:1.6,max:3.2}},
        move:{enable:true, speed:0.3, direction:"none", outModes:{default:"bounce"}, random:true, straight:false},
        links:{enable:true, distance:140, color:"#ffffff", opacity:0.08, width:1},
        shape:{type:"circle"}
      },
      interactivity:{detectsOn:"window", events:{onHover:{enable:false}, onClick:{enable:false}, resize:true}}
    }
  });
})();
</script>

<!-- Colilargos: doble capa + ZONAS PROHIBIDAS (logo, título, letras, CTAs) + 3 comportamientos -->
<script>
(() => {
  const cBack  = document.getElementById("sperm-back");
  const cFront = document.getElementById("sperm-front");
  const ctxB = cBack.getContext("2d");
  const ctxF = cFront.getContext("2d");

  let cssW, cssH, dpr = Math.max(1, window.devicePixelRatio || 1);

  // Ajustes visuales
  const COUNT=100, SPEED=60, TAIL_LEN=40, FADE_TIME=1.2, TAIL_DELAY=0.15;
  const DOT_STEP=1, DOT_RADIUS=2.0, DOT_FADE=0.025;

  const sperms=[];
  let forbiddenCircle={x:0,y:0,r:0}; // logo
  let forbiddenRects=[];             // título, letras (tagline) y CTAs

  function rand(a,b){ return a + Math.random()*(b-a); }

  function resizeCanvas(el){ el.width=Math.max(1,Math.floor(el.clientWidth*dpr)); el.height=Math.max(1,Math.floor(el.clientHeight*dpr)); }
  function resizeAll(){
    cssW=cFront.clientWidth; cssH=cFront.clientHeight;
    resizeCanvas(cBack); resizeCanvas(cFront);
    updateForbidden();
  }
  window.addEventListener("resize", resizeAll, {passive:true});
  window.addEventListener("load", resizeAll, {passive:true});
  resizeAll();

  // --- Zonas prohibidas ---
  function updateForbidden(){
    const heroRect = document.querySelector(".hero-bg").getBoundingClientRect();

    // Logo (círculo con padding)
    const logo = document.getElementById("hero-logo");
    if (logo){
      const r = logo.getBoundingClientRect();
      forbiddenCircle = {
        x: (r.left + r.right)/2 - heroRect.left,
        y: (r.top  + r.bottom)/2 - heroRect.top,
        r:  r.width/2 * 1.06
      };
    }

    // Título, letras (tagline) y CTAs como rectángulos
    forbiddenRects = [];
    const pad = 10;
    const addRect = (el, extraPad=pad) => {
      if(!el) return;
      const r = el.getBoundingClientRect();
      forbiddenRects.push({
        x: r.left - heroRect.left - extraPad,
        y: r.top  - heroRect.top  - extraPad,
        w: r.width  + extraPad*2,
        h: r.height + extraPad*2
      });
    };
    addRect(document.getElementById("hero-title"), 6);
    addRect(document.getElementById("hero-ctas"), 8);
  }

  function spawn(){
    const x=Math.random()*cssW, y=Math.random()*cssH;
    // elegir comportamiento: 60% normal, 30% zigzag, 10% pausey
    let behavior="normal";
    const r=Math.random();
    if (r>=0.6 && r<0.9) behavior="zigzag";
    else if (r>=0.9) behavior="pausey";

    const born = performance.now()/1000;

    const s = {
      x,y, angle:Math.random()*Math.PI*2, speed:SPEED*(0.8+Math.random()*0.4),
      tail:Array.from({length:TAIL_LEN},()=>({x,y})), born, layer:"back",
      behavior
    };

    if(behavior==="zigzag"){
      s.zigAmp = rand(0.18,0.32);     // giro por paso
      s.zigStep = rand(0.06,0.12);    // cada cuánto alterna (s)
      s._zigTimer = 0;
      s._zigSign = Math.random()<0.5 ? 1 : -1;
    } else if(behavior==="pausey"){
      s.isPaused=false;
      s.pauseDur = rand(0.25,0.8);
      s.nextPause = born + rand(1.5,3.5);
      s.speedFactor = 1;
    }
    return s;
  }
  for(let i=0;i<COUNT;i++) sperms.push(spawn());

  function update(s,dt,t){
    if(s.layer==="back" && (t-s.born)>=FADE_TIME) s.layer="front";

    // --- Movimiento según comportamiento ---
    if(s.behavior==="normal"){
      s.angle += Math.sin(t*2 + s.x*0.01)*0.05;
    } else if(s.behavior==="zigzag"){
      // alterna rápidamente la dirección de giro, con un ligero ruido
      s._zigTimer += dt;
      if(s._zigTimer >= s.zigStep){
        s._zigTimer = 0;
        s._zigSign *= -1;
      }
      s.angle += s._zigSign * s.zigAmp + Math.sin(t*5 + s.x*0.02)*0.02;
    } else if(s.behavior==="pausey"){
      s.angle += Math.sin(t*2 + s.x*0.01)*0.05;
      // gestionar pausas aleatorias
      if(!s.isPaused && t >= s.nextPause){
        s.isPaused = true;
        s.pauseEnd = t + s.pauseDur;
      }
      if(s.isPaused){
        s.speedFactor = Math.max(0, s.speedFactor - dt*4); // frena rápido
        if(t >= s.pauseEnd){
          s.isPaused=false;
          s.nextPause = t + rand(1.5,3.5);
        }
      } else {
        s.speedFactor = Math.min(1, s.speedFactor + dt*2); // acelera suave
      }
    }

    const factor = (s.behavior==="pausey") ? (s.speedFactor ?? 1) : 1;

    s.x += Math.cos(s.angle)*s.speed*dt*factor;
    s.y += Math.sin(s.angle)*s.speed*dt*factor;

    // wrap bordes
    if(s.x<0) s.x=cssW; if(s.x>cssW) s.x=0; if(s.y<0) s.y=cssH; if(s.y>cssH) s.y=0;

    // evitar logo (círculo)
    const dx=s.x-forbiddenCircle.x, dy=s.y-forbiddenCircle.y;
    const dist=Math.hypot(dx,dy);
    if(dist < forbiddenCircle.r){
      const ang=Math.atan2(dy,dx);
      s.x=forbiddenCircle.x+Math.cos(ang)*(forbiddenCircle.r+6);
      s.y=forbiddenCircle.y+Math.sin(ang)*(forbiddenCircle.r+6);
      s.angle=ang + (Math.random()-0.5);
    }

    // evitar rectángulos (título, letras, CTAs)
    for(const R of forbiddenRects){
      if(s.x>R.x && s.x<R.x+R.w && s.y>R.y && s.y<R.y+R.h){
        const leftDist   = Math.abs(s.x - R.x);
        const rightDist  = Math.abs(R.x + R.w - s.x);
        const topDist    = Math.abs(s.y - R.y);
        const bottomDist = Math.abs(R.y + R.h - s.y);
        const minD = Math.min(leftDist, rightDist, topDist, bottomDist);
        const offset = 6;
        if(minD === leftDist){ s.x = R.x - offset;  s.angle = Math.PI - s.angle; }
        else if(minD === rightDist){ s.x = R.x + R.w + offset; s.angle = Math.PI - s.angle; }
        else if(minD === topDist){ s.y = R.y - offset; s.angle = -s.angle; }
        else { s.y = R.y + R.h + offset; s.angle = -s.angle; }
      }
    }

    // actualizar cola
    s.tail[0].x=s.x; s.tail[0].y=s.y;
    for(let i=1;i<TAIL_LEN;i++){
      const p=s.tail[i-1], c=s.tail[i];
      c.x += (p.x-c.x)*0.4; c.y += (p.y-c.y)*0.4;
    }
  }

  // Cabeza con forma de espermatozoide
  function drawHeadSperm(ctx, xPx, yPx, angleRad){
    ctx.save();
    ctx.translate(xPx, yPx);
    ctx.rotate(angleRad);
    const rx = 2.0 * dpr;   // semi-eje ancho
    const ry = 3.4 * dpr;   // semi-eje largo
    ctx.fillStyle = "rgba(255,255,255,0.95)";
    ctx.beginPath();
    ctx.ellipse(0, 0, rx, ry, 0, 0, Math.PI*2);
    ctx.fill();
    // pequeña punta frontal
    ctx.beginPath();
    ctx.moveTo(0, -ry);
    ctx.quadraticCurveTo(rx*0.6, -ry*0.6, 0, -ry*0.15);
    ctx.quadraticCurveTo(-rx*0.6, -ry*0.6, 0, -ry);
    ctx.fill();
    ctx.restore();
  }

  function drawOne(ctx,s,t){
    const age=t-s.born;
    let alpha=1; if(s.layer==="back") alpha=Math.min(1, age/FADE_TIME);

    const hx=s.x*dpr, hy=s.y*dpr;
    ctx.save(); ctx.globalAlpha=alpha; ctx.imageSmoothingEnabled=true;

    // cabeza orientada
    drawHeadSperm(ctx, hx, hy, s.angle - Math.PI/2);

    // cola en puntos densos (sin stroke → sin hairlines)
    if(age>TAIL_DELAY){
      for(let i=1;i<TAIL_LEN;i+=DOT_STEP){
        const p=s.tail[i]; const px=p.x*dpr, py=p.y*dpr;
        const r = Math.max(0.8, (DOT_RADIUS - i*0.03) * dpr); //Gorsor de cola
        const a = Math.max(0, 0.6 - i*DOT_FADE);
        if(r<=0 || a<=0) continue;
        ctx.fillStyle=`rgba(255,255,255,${a})`;
        ctx.beginPath(); ctx.arc(px,py,r,0,Math.PI*2); ctx.fill();
      }
    }
    ctx.restore();
  }

  let last=performance.now();
  function loop(nowMS){
    const now=nowMS/1000, dt=Math.min(0.033,(nowMS-last)/1000); last=nowMS;
    ctxB.setTransform(1,0,0,1,0,0); ctxB.clearRect(0,0,cBack.width,cBack.height);
    ctxF.setTransform(1,0,0,1,0,0); ctxF.clearRect(0,0,cFront.width,cFront.height);
    for(const s of sperms){ update(s,dt,now); (s.layer==="back"?drawOne.bind(null,ctxB):drawOne.bind(null,ctxF))(s,now); }
    requestAnimationFrame(loop);
  }
  requestAnimationFrame(loop);
})();
</script>
