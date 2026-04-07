/* ============================================
   JTT Portfolio — main.js
   Navigation mobile, scroll reveal, active link
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ---- NAVIGATION MOBILE (burger) ---- */
  const burger = document.querySelector('.nav-burger');
  const navLinks = document.querySelector('.nav-links');

  if (burger && navLinks) {
    burger.addEventListener('click', function () {
      navLinks.classList.toggle('open');
      burger.classList.toggle('active');
      burger.setAttribute('aria-expanded', navLinks.classList.contains('open'));
    });

    // Fermer le menu en cliquant sur un lien
    navLinks.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        navLinks.classList.remove('open');
        burger.classList.remove('active');
        burger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ---- SCROLL REVEAL ---- */
  const reveals = document.querySelectorAll('.reveal');

  if (reveals.length > 0) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    reveals.forEach(function (el) { observer.observe(el); });
  }

  /* ---- HEADER STICKY SHADOW ---- */
  const header = document.querySelector('.site-header');

  if (header) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 40) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  }

  /* ---- LIEN ACTIF DANS LA NAV ---- */
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-links a').forEach(function (link) {
    if (link.getAttribute('href') === currentPath ||
        currentPath.includes(link.getAttribute('href'))) {
      link.classList.add('current-menu-item');
    }
  });

});
