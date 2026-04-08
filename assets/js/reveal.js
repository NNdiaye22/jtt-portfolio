/* =================================================
   JTT Portfolio — reveal.js
   IntersectionObserver + GSAP matchMedia
   ================================================= */

/* ══ Work items : slide-up / lumière au scroll (tous écrans) ══ */
function initObserver() {
  var items = document.querySelectorAll('.work-item');
  if (!items.length) return;

  /* Seuil 0.05 : déclenche dès que 5 % de la carte est visible */
  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.05, rootMargin: '0px 0px -20px 0px' });

  items.forEach(function (item) { observer.observe(item); });
}

/* ══ Effets GSAP adaptés au breakpoint via matchMedia ══ */
function initScrollEffects() {
  if (!window.gsap || !window.ScrollTrigger) return;

  /* Dividers (tous écrans) */
  document.querySelectorAll('[data-divider]').forEach(function (d) {
    ScrollTrigger.create({
      trigger: d, start: 'top 87%',
      onEnter: function () { d.classList.add('drawn'); }
    });
  });

  /* Titres masqués (tous écrans) */
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

  var mm = gsap.matchMedia();

  /* — Desktop : glissement horizontal — */
  mm.add('(min-width: 1025px)', function () {
    var ai = document.querySelector('.about-image-wrap');
    var at = document.querySelector('.about-text');
    if (ai) {
      gsap.fromTo(ai,
        { opacity: 0, x: -40 },
        { opacity: 1, x: 0, duration: 1.2, ease: 'power3.out',
          scrollTrigger: { trigger: ai, start: 'top 85%', once: true }
        }
      );
    }
    if (at) {
      gsap.fromTo(at,
        { opacity: 0, x: 40 },
        { opacity: 1, x: 0, duration: 1.2, ease: 'power3.out', delay: 0.15,
          scrollTrigger: { trigger: at, start: 'top 85%', once: true }
        }
      );
    }
  });

  /* — Tablette + Mobile (≤ 1024px) : fade-up, déclenchement haut de page — */
  mm.add('(max-width: 1024px)', function () {
    var ai = document.querySelector('.about-image-wrap');
    var at = document.querySelector('.about-text');
    /* Nettoie les inline styles GSAP du desktop */
    if (ai) gsap.set(ai, { clearProps: 'all' });
    if (at) gsap.set(at, { clearProps: 'all' });
    if (ai) {
      gsap.fromTo(ai,
        { opacity: 0, y: 24 },
        { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out',
          scrollTrigger: { trigger: ai, start: 'top 95%', once: true }
        }
      );
    }
    if (at) {
      gsap.fromTo(at,
        { opacity: 0, y: 24 },
        { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out', delay: 0.1,
          scrollTrigger: { trigger: at, start: 'top 95%', once: true }
        }
      );
    }
  });
}

/* ══ Hero name ══ */
function buildHeroName(useGsap) {
  var nameEl = document.querySelector('.hero-name');
  if (!nameEl) return;
  var fullName = nameEl.getAttribute('aria-label') || 'JULIEN TERENCE TEGNAN';
  nameEl.innerHTML = '';
  fullName.split('').forEach(function (ch) {
    var sp = document.createElement('span');
    sp.className = 'char';
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
