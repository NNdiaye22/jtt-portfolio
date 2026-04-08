/* ==============================================
   JTT Portfolio — reveal.js
   IntersectionObserver pour .reveal, .reveal-img,
   .reveal-inner et .section-divider
   ============================================== */
(function () {
  // Respect de prefers-reduced-motion
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // --- Éléments .reveal et .reveal-img ---
  var revealEls = document.querySelectorAll('.reveal, .reveal-img');
  if (revealEls.length > 0) {
    if (reducedMotion) {
      revealEls.forEach(function (el) { el.classList.add('visible'); });
    } else {
      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

      revealEls.forEach(function (el) { revealObserver.observe(el); });
    }
  }

  // --- Éléments .reveal-inner (masques de texte) ---
  var innerEls = document.querySelectorAll('.reveal-inner');
  if (innerEls.length > 0) {
    if (reducedMotion) {
      innerEls.forEach(function (el) { el.classList.add('visible'); });
    } else {
      var innerObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            innerObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      innerEls.forEach(function (el) { innerObserver.observe(el); });
    }
  }

  // --- Section dividers (ligne animée) ---
  var dividers = document.querySelectorAll('.section-divider');
  if (dividers.length > 0) {
    if (reducedMotion) {
      dividers.forEach(function (el) { el.classList.add('drawn'); });
    } else {
      var dividerObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('drawn');
            dividerObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.5 });

      dividers.forEach(function (el) { dividerObserver.observe(el); });
    }
  }
})();
