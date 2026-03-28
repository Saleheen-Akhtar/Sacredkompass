document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(ScrollTrigger);

  // 1. Smooth Fade-Up for sections
  gsap.utils.toArray('.gsap-fade-up').forEach(section => {
    gsap.fromTo(section,
      { y: 50, opacity: 0 },
      {
        y: 0, opacity: 1, duration: 1, ease: "power3.out",
        scrollTrigger: {
          trigger: section,
          start: "top 85%", // Trigger when top of section hits 85% of viewport height
        }
      }
    );
  });

  // 2. Subtle Parallax for Hero Backgrounds
  gsap.utils.toArray('.gsap-parallax').forEach(parallax => {
    gsap.to(parallax, {
      backgroundPosition: "50% 100%",
      ease: "none",
      scrollTrigger: {
        trigger: parallax,
        start: "top top",
        end: "bottom top",
        scrub: true
      }
    });
  });

  // Mobile hamburger menu logic (retained)
  const hamburger = document.querySelector('.nav-hamburger');
  const overlay   = document.querySelector('.nav-mobile-overlay');

  if (hamburger && overlay) {
    hamburger.addEventListener('click', () => {
      const isOpen = hamburger.classList.toggle('open');
      overlay.classList.toggle('open', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });
  }
});
