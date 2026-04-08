/* =================================================
   JTT Portfolio — reveal.js
   IntersectionObserver pour .work-item,
   .section-divider, .reveal-inner, et effets GSAP
   ================================================= */

/* ══ Tiles de la grille projets : révélation par la lumière ══ */
function initObserver() {
  var items = document.querySelectorAll('.work-item');
  if (!items.length) return;

  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  items.forEach(function (item) { observer.observe(item); });
}

/* ══ Dividers + titres masqués + about (GSAP + ScrollTrigger) ══ */
function initScrollEffects() {
  if (!window.ScrollTrigger) return;

  /* Lignes diviseurs */
  document.querySelectorAll('[data-divider]').forEach(function (d) {
    ScrollTrigger.create({
      trigger: d, start: 'top 87%',
      onEnter: function () { d.classList.add('drawn'); }
    });
  });

  /* Titres masqués (.reveal-inner) */
  document.querySelectorAll('.reveal-inner').forEach(function (el) {
    gsap.fromTo(el,
      { y: '100%', opacity: 0 },
      { y: '0%', opacity: 1, duration: 1.1, ease: 'power4.out',
        scrollTrigger: { trigger: el, start: 'top 92%', once: true }
      }
    );
  });

  /* Work count */
  var wc = document.querySelector('.work-count');
  if (wc) {
    gsap.to(wc, { opacity: 1, duration: 0.7, ease: 'power2.out',
      scrollTrigger: { trigger: wc, start: 'top 90%', once: true }
    });
  }

  /* Manifesto */
  var mt = document.querySelector('.manifesto-text');
  if (mt) {
    gsap.fromTo(mt,
      { opacity: 0, y: 30 },
      { opacity: 1, y: 0, duration: 1.2, ease: 'power3.out',
        scrollTrigger: { trigger: mt, start: 'top 85%', once: true }
      }
    );
  }

  /* About image + texte */
  var ai = document.querySelector('.about-image-wrap');
  var at = document.querySelector('.about-text');
  if (ai) {
    gsap.to(ai, { opacity: 1, x: 0, duration: 1.2, ease: 'power3.out',
      scrollTrigger: { trigger: ai, start: 'top 85%', once: true }
    });
  }
  if (at) {
    gsap.to(at, { opacity: 1, x: 0, duration: 1.2, ease: 'power3.out', delay: 0.15,
      scrollTrigger: { trigger: at, start: 'top 85%', once: true }
    });
  }
}

/* ══ Hero name — stagger caractère par caractère ══ */
function buildHeroName(useGsap) {
  var nameEl = document.querySelector('.hero-name');
  if (!nameEl) return;
  var fullName = nameEl.getAttribute('aria-label') || 'JULIEN TERENCE TEGNAN';
  nameEl.innerHTML = '';
  fullName.split('').forEach(function (ch) {
    var sp = document.createElement('span');
    sp.className   = 'char';
    sp.textContent = ch === ' ' ? '\u00A0' : ch;
    nameEl.appendChild(sp);
  });

  if (!useGsap) {
    document.querySelectorAll('.char').forEach(function (c) {
      c.style.opacity = '1'; c.style.transform = 'none';
    });
    return;
  }

  gsap.timeline({ delay: 0.05 })
    .to('.monogram',      { opacity: 1, duration: 0.9, ease: 'power2.out' })
    .to('.char',          { opacity: 1, y: 0, duration: 0.42, stagger: 0.024, ease: 'power3.out' }, '-=0.35')
    .to('.hero-subtitle', { opacity: 1, duration: 0.7, ease: 'power2.out' }, '-=0.1')
    .to('.hero-quote',    { opacity: 1, duration: 0.9, ease: 'power2.out' }, '-=0.35')
    .to('.hero-buttons',  { opacity: 1, duration: 0.7, ease: 'power2.out' }, '-=0.35')
    .to('.hero-socials',  { opacity: 1, duration: 0.6, ease: 'power2.out' }, '-=0.25')
    .to('#scrollHint',    { opacity: 0.55, duration: 0.7, ease: 'power2.out' }, '-=0.2');
}

/* ══ Smooth anchor scroll ══ */
function initAnchorScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}
