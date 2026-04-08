/* =================================================
   JTT Portfolio — cursor.js
   Curseur personnalisé avec effet magnétique
   ================================================= */
function initCursor() {
  var cur = document.getElementById('cursor');
  if (!cur) return;
  var mx = 0, my = 0, cx = 0, cy = 0;

  document.addEventListener('mousemove', function (e) {
    mx = e.clientX;
    my = e.clientY;
  });

  (function loop() {
    cx += (mx - cx) * 0.12;
    cy += (my - cy) * 0.12;
    cur.style.left = cx + 'px';
    cur.style.top  = cy + 'px';
    requestAnimationFrame(loop);
  }());

  document.querySelectorAll('.work-item, .btn, .hero-socials a, .footer-socials a, a, button').forEach(function (el) {
    el.addEventListener('mouseenter', function () { cur.classList.add('grow'); });
    el.addEventListener('mouseleave', function () { cur.classList.remove('grow'); });
  });
}

document.addEventListener('DOMContentLoaded', function () {
  /* Le curseur est inité par initAll() après le loader,
     mais on l’active aussi en fallback immédiat si nécessaire */
  if (document.readyState === 'complete' && typeof initCursor !== 'undefined') {
    initCursor();
  }
});
