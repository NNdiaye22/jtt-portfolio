/* ==============================================
   JTT Portfolio — loader.js
   Anime la barre de chargement et masque le loader
   ============================================== */
(function () {
  var loader  = document.getElementById('loader');
  var bar     = document.getElementById('loaderBar');
  var pctEl   = document.getElementById('loaderPct');
  var nav     = document.getElementById('site-nav');

  if (!loader || !bar) {
    // Sécurité : si le loader est absent, on s'assure que la nav est visible
    if (nav) nav.classList.add('nav-visible');
    return;
  }

  var progress = 0;

  // Simule une progression fluide jusqu'à 85 %
  var interval = setInterval(function () {
    if (progress < 85) {
      progress += Math.random() * 12 + 3;
      if (progress > 85) progress = 85;
      bar.style.width = progress + '%';
      if (pctEl) pctEl.textContent = Math.round(progress);
    }
  }, 80);

  // Quand la page est complètement chargée, finalise à 100 %
  window.addEventListener('load', function () {
    clearInterval(interval);
    progress = 100;
    bar.style.width = '100%';
    if (pctEl) pctEl.textContent = '100';

    // Laisse 350 ms pour que l'utilisateur voit 100 %, puis fade out
    setTimeout(function () {
      loader.classList.add('fade-out');
      if (nav) nav.classList.add('nav-visible');

      // Après la transition CSS (0.85s), cache définitivement le loader
      loader.addEventListener('transitionend', function () {
        loader.classList.add('hidden');
      }, { once: true });

      // Fallback si transitionend ne se déclenche pas
      setTimeout(function () {
        loader.classList.add('hidden');
      }, 1000);
    }, 350);
  });
})();
