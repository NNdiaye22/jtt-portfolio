/* ==============================================
   JTT Portfolio — menu.js
   Menu mobile overlay (burger / close)
   ============================================== */
(function () {
  var burger    = document.getElementById('navBurger');
  var overlay   = document.getElementById('navMobile');
  var closeBtn  = document.getElementById('navMobileClose');

  if (!burger || !overlay) return;

  function openMenu() {
    overlay.classList.add('is-open');
    overlay.setAttribute('aria-hidden', 'false');
    burger.classList.add('is-open');
    burger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    overlay.classList.remove('is-open');
    overlay.setAttribute('aria-hidden', 'true');
    burger.classList.remove('is-open');
    burger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  burger.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);

  // Ferme le menu quand on clique sur un lien
  var links = overlay.querySelectorAll('a');
  links.forEach(function (link) {
    link.addEventListener('click', closeMenu);
  });

  // Ferme avec Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
      closeMenu();
      burger.focus();
    }
  });
})();
