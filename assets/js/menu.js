/* =================================================
   JTT Portfolio — menu.js
   Menu mobile overlay + header sticky
   ================================================= */
function initMenu() {
  var burger  = document.querySelector('.nav-burger');
  var overlay = document.querySelector('.nav-mobile-overlay');
  var close   = document.querySelector('.nav-overlay-close');
  var links   = document.querySelectorAll('.nav-overlay-links a');

  if (burger && overlay) {
    burger.addEventListener('click', function () {
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  }

  if (close && overlay) {
    close.addEventListener('click', function () {
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    });
  }

  links.forEach(function (link) {
    link.addEventListener('click', function () {
      if (overlay) overlay.classList.remove('open');
      document.body.style.overflow = '';
    });
  });
}

/* Header : réduction au scroll */
function initNav() {
  if (window.gsap) {
    gsap.to('#site-nav, nav', { opacity: 1, duration: 1.1, delay: 0.25, ease: 'power2.out' });
  } else {
    var navEl = document.querySelector('#site-nav, nav');
    if (navEl) navEl.style.opacity = '1';
  }

  var header = document.querySelector('#site-nav, nav');
  if (!header) return;
  window.addEventListener('scroll', function () {
    if (window.scrollY > 60) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
}

document.addEventListener('DOMContentLoaded', initMenu);
