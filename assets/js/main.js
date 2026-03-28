/* Sacred Kompass — main.js v3.0 */
(function () {
  'use strict';

  /* ── Scroll progress bar ─────────────────────── */
  const progressBar = document.createElement('div');
  progressBar.className = 'sk-progress';
  document.body.prepend(progressBar);

  /* ── NAV scroll + progress combined ─────────── */
  const nav = document.getElementById('sk-nav');

  const onScroll = () => {
    const scrolled = window.scrollY;
    const docH = document.documentElement.scrollHeight - window.innerHeight;

    // Scrolled nav
    if (nav) nav.classList.toggle('scrolled', scrolled > 60);

    // Progress bar
    const pct = docH > 0 ? (scrolled / docH) * 100 : 0;
    progressBar.style.width = pct + '%';

    // Parallax hero image
    const heroParallax = document.querySelector('.hero-image-parallax');
    if (heroParallax) {
      const speed = 0.35;
      heroParallax.style.transform = `translateY(${scrolled * speed}px)`;
    }
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ── Hero journey stages ─────────────────────── */
  document.querySelectorAll('.journey-stage').forEach((el) => {
    requestAnimationFrame(() => el.classList.add('visible'));
  });

  /* ── Scroll reveal ───────────────────────────── */
  const reveals = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            e.target.classList.add('visible');
            io.unobserve(e.target);
          }
        });
      },
      { threshold: 0.08, rootMargin: '0px 0px -40px 0px' }
    );
    reveals.forEach((el) => io.observe(el));
  } else {
    reveals.forEach((el) => el.classList.add('visible'));
  }

  /* ── Mobile hamburger ────────────────────────── */
  const hamburger = document.querySelector('.nav-hamburger');
  const overlay   = document.querySelector('.nav-mobile-overlay');

  if (hamburger && overlay) {
    hamburger.addEventListener('click', () => {
      const isOpen = hamburger.classList.toggle('open');
      overlay.classList.toggle('open', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close on overlay link click
    overlay.querySelectorAll('a').forEach((a) => {
      a.addEventListener('click', () => {
        hamburger.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
      });
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && overlay.classList.contains('open')) {
        hamburger.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
      }
    });
  }

  /* ── FAQ accordion ───────────────────────────── */
  document.querySelectorAll('.faq-trigger').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const isOpen    = trigger.getAttribute('aria-expanded') === 'true';
      const controlId = trigger.getAttribute('aria-controls');
      const body      = document.getElementById(controlId);

      // Close all
      document.querySelectorAll('.faq-trigger').forEach((t) => {
        t.setAttribute('aria-expanded', 'false');
        const b = document.getElementById(t.getAttribute('aria-controls'));
        if (b) b.classList.remove('open');
      });

      // Open if was closed
      if (!isOpen && body) {
        trigger.setAttribute('aria-expanded', 'true');
        body.classList.add('open');
      }
    });
  });

  /* ── Smooth anchor scroll ────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach((a) => {
    a.addEventListener('click', (e) => {
      const id = a.getAttribute('href').slice(1);
      if (!id) return;
      const el = document.getElementById(id);
      if (!el) return;
      e.preventDefault();
      const navEl  = document.getElementById('sk-nav');
      const offset = navEl ? navEl.offsetHeight + 24 : 80;
      const top    = el.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });
    });
  });

  /* ── Active nav link highlight on scroll ──────── */
  const sections = ['about', 'offerings', 'founders', 'faq', 'contact'];
  const navLinksAll = document.querySelectorAll('.nav-links a, .nav-mobile-overlay a');

  const highlightNav = () => {
    const scrollMid = window.scrollY + window.innerHeight / 2;
    let active = '';
    sections.forEach((id) => {
      const el = document.getElementById(id);
      if (el && el.offsetTop <= scrollMid) active = id;
    });
    navLinksAll.forEach((a) => {
      const href = a.getAttribute('href') || '';
      a.classList.toggle('active', href === `#${active}` || href.endsWith(`/#${active}`));
    });
  };

  window.addEventListener('scroll', highlightNav, { passive: true });

})();
