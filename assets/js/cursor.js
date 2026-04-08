/* ==============================================
   JTT Portfolio — cursor.js
   Curseur custom : déplacement + effet grow
   ============================================== */
(function () {
  var cursor = document.getElementById('cursor');
  if (!cursor) return;

  // Masque le curseur par défaut sur desktop
  var mouseX = 0, mouseY = 0;
  var curX = 0, curY = 0;
  var raf;

  document.addEventListener('mousemove', function (e) {
    mouseX = e.clientX;
    mouseY = e.clientY;
  });

  // Animation fluide par interpolation
  function animateCursor() {
    curX += (mouseX - curX) * 0.12;
    curY += (mouseY - curY) * 0.12;
    cursor.style.left = curX + 'px';
    cursor.style.top  = curY + 'px';
    raf = requestAnimationFrame(animateCursor);
  }
  raf = requestAnimationFrame(animateCursor);

  // Effet grow sur les éléments interactifs
  var growTargets = document.querySelectorAll('a, button, [role="button"], .projet-card');
  growTargets.forEach(function (el) {
    el.addEventListener('mouseenter', function () { cursor.classList.add('grow'); });
    el.addEventListener('mouseleave', function () { cursor.classList.remove('grow'); });
  });

  // Cache le curseur custom quand la souris quitte la fenêtre
  document.addEventListener('mouseleave', function () { cursor.style.opacity = '0'; });
  document.addEventListener('mouseenter', function () { cursor.style.opacity = '1'; });
})();
