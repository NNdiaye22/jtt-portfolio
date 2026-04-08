/* =================================================
   JTT Portfolio — carousel.js
   Carousel mobile Works : scroll-snap + dots + hint
   S'active UNIQUEMENT sur mobile (≤ 600px)
   Ne touche pas au comportement desktop/tablette
   ================================================= */

function initWorkCarousel() {
  /* Ne rien faire si on n'est pas sur mobile */
  if (window.innerWidth > 600) return;

  var grid  = document.querySelector('.work-grid');
  var items = document.querySelectorAll('.work-item');
  if (!grid || !items.length) return;

  var count = items.length;

  /* — 1. Rendre toutes les cartes visibles immédiatement (pas d'IO sur carousel) — */
  items.forEach(function (item) {
    item.classList.add('is-visible');
  });

  /* — 2. Injecter les points (dots) après la grille — */
  var dotsWrap = document.createElement('div');
  dotsWrap.className = 'work-dots';
  var dots = [];
  for (var i = 0; i < count; i++) {
    var dot = document.createElement('button');
    dot.className = 'work-dot';
    dot.setAttribute('aria-label', 'Collection ' + (i + 1));
    dotsWrap.appendChild(dot);
    dots.push(dot);
  }
  grid.parentNode.insertBefore(dotsWrap, grid.nextSibling);

  /* — 3. Injecter le hint swipe — */
  var hint = document.createElement('p');
  hint.className = 'work-swipe-hint';
  hint.innerHTML =
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">'
    + '<path d="M5 12h14M13 6l6 6-6 6"/>'
    + '</svg>'
    + '<span>Swipe</span>';
  dotsWrap.parentNode.insertBefore(hint, dotsWrap.nextSibling);

  /* — 4. Mettre à jour le dot actif au scroll — */
  var currentIndex = 0;

  function updateDots(index) {
    dots.forEach(function (d, i) {
      d.classList.toggle('active', i === index);
    });
    currentIndex = index;
  }
  updateDots(0);

  /* Détecte la carte centrée via scrollLeft */
  var scrollTimer;
  grid.addEventListener('scroll', function () {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(function () {
      var slideWidth = items[0].getBoundingClientRect().width + 8; /* 8px = margin */
      var index = Math.round(grid.scrollLeft / slideWidth);
      index = Math.max(0, Math.min(index, count - 1));
      if (index !== currentIndex) updateDots(index);

      /* Cache le hint au premier swipe */
      if (grid.scrollLeft > 20 && !hint.classList.contains('hidden')) {
        hint.classList.add('hidden');
      }
    }, 50);
  }, { passive: true });

  /* — 5. Clic sur un dot → scroll vers la carte — */
  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () {
      var slideWidth = items[0].getBoundingClientRect().width + 8;
      grid.scrollTo({ left: i * slideWidth, behavior: 'smooth' });
    });
  });
}

document.addEventListener('DOMContentLoaded', initWorkCarousel);

/* Re-init si la fenêtre est redimensionnée (ex: rotation téléphone) */
window.addEventListener('resize', (function () {
  var t;
  return function () {
    clearTimeout(t);
    t = setTimeout(function () {
      /* Nettoie les éléments injectés avant de re-init */
      var old = document.querySelectorAll('.work-dots, .work-swipe-hint');
      old.forEach(function (el) { el.remove(); });
      initWorkCarousel();
    }, 200);
  };
})());
