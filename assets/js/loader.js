/* =================================================
   JTT Portfolio — loader.js
   Anime la barre de chargement, puis lance les scripts
   via bootGSAP() une fois à 100 %.
   ================================================= */
(function () {
  var bar  = document.getElementById('loaderBar');
  var pct  = document.getElementById('loaderPct');
  var el   = document.getElementById('loader');
  var nav  = document.getElementById('site-nav');
  var prog = 0;
  var done = false;
  var timer, guard;

  if (!el || !bar) return;

  function dismiss() {
    if (done) return;
    done = true;
    clearInterval(timer);
    clearTimeout(guard);
    bar.style.width  = '100%';
    if (pct) pct.textContent = '100';

    setTimeout(function () {
      el.classList.add('fade-out');
      if (nav) nav.classList.add('nav-visible');

      setTimeout(function () {
        el.classList.add('hidden');
        if (typeof bootGSAP === 'function') bootGSAP();
        else if (typeof initFallback === 'function') initFallback();
      }, 900);
    }, 300);
  }

  timer = setInterval(function () {
    prog += Math.random() * 16 + 5;
    if (prog >= 100) { dismiss(); return; }
    bar.style.width = prog + '%';
    if (pct) pct.textContent = Math.floor(prog);
  }, 65);

  /* Filet absolu : 2 secondes */
  guard = setTimeout(dismiss, 2000);
}());


/* =================================================
   STEP 2 — Charge GSAP après la fermeture du loader
   ================================================= */
function bootGSAP() {
  var s1 = document.createElement('script');
  s1.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js';
  s1.onload = function () {
    var s2 = document.createElement('script');
    s2.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js';
    s2.onload  = initAll;
    s2.onerror = initFallback;
    document.head.appendChild(s2);
  };
  s1.onerror = initFallback;
  document.head.appendChild(s1);
}


/* =================================================
   FALLBACK si GSAP indisponible
   ================================================= */
function initFallback() {
  var navEl = document.querySelector('#site-nav, nav');
  if (navEl) navEl.style.opacity = '1';
  var show = '.monogram,.hero-subtitle,.hero-quote,.hero-buttons,.hero-socials,#scrollHint,.reveal-inner,.work-count,.section-label,.about-image-wrap,.about-text,.manifesto-text';
  document.querySelectorAll(show).forEach(function (e) {
    e.style.opacity = '1';
    e.style.transform = 'none';
  });
  if (typeof buildHeroName === 'function') buildHeroName(false);
  if (typeof initObserver === 'function') initObserver();
  if (typeof initCursor  === 'function') initCursor();
}


/* =================================================
   STEP 3 — INIT PRINCIPALE (GSAP disponible)
   ================================================= */
function initAll() {
  if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);
  if (typeof buildHeroName       === 'function') buildHeroName(true);
  if (typeof initNav             === 'function') initNav();
  if (typeof initScrollEffects   === 'function') initScrollEffects();
  if (typeof initObserver        === 'function') initObserver();
  if (typeof initCursor          === 'function') initCursor();
  if (typeof initAnchorScroll    === 'function') initAnchorScroll();
}
