const toggle = document.querySelector('.header__toggle');
const close  = document.querySelector('.header__close');
const drawer = document.querySelector('.header__drawer');

function openMenu() {
  drawer.classList.add('is-open');
  drawer.setAttribute('aria-hidden', 'false');
  toggle.setAttribute('aria-expanded', 'true');
  document.body.style.overflow = 'hidden';
}

function closeMenu() {
  drawer.classList.remove('is-open');
  drawer.setAttribute('aria-hidden', 'true');
  toggle.setAttribute('aria-expanded', 'false');
  document.body.style.overflow = '';
}

toggle?.addEventListener('click', openMenu);
close?.addEventListener('click', closeMenu);

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeMenu();
});

// ─── Partner modal (mobile only) ──────────────────────────────────────────────

(function () {
  const modal = document.getElementById('partner-modal');
  if (!modal) return;

  const descriptions = [
    'ENI-STRUT is engineered to deliver reliable and efficient support solutions for modern electrical, mechanical, and infrastructure projects. Designed with strength, flexibility, and precision in mind, ENI-STRUT systems provide a versatile framework for cable management, equipment mounting, and structural support across commercial, industrial, and large-scale construction environments. Built to meet demanding project requirements, each component is manufactured for durability, ease of installation, and long-term performance in challenging site conditions.',
    'INDELEC, founded in France and backed by more than 70 years of expertise, is globally recognized for advanced lightning protection and grounding system solutions engineered to safeguard critical infrastructure. Combining French innovation with decades of field-proven performance, INDELEC delivers integrated systems that include lightning protection technologies, earthing and grounding components, surge protection solutions, and accessories designed to ensure electrical safety and system reliability across commercial, industrial, and high-risk environments.',
    'Delta Box, a French-engineered brand and subsidiary of the INDELEC Group, brings more than 30 years of expertise in advanced aviation safety and infrastructure solutions. Based in Douai, France, the company specializes in the design and manufacturing of aircraft warning lights, obstruction lighting systems, and related technologies developed to protect critical structures and ensure safe airspace operations worldwide.',
    'Cablofil, originally developed in France and now part of the global portfolio of Legrand, represents precision-engineered cable management trusted worldwide. Designed to meet the rigorous demands of modern electrical infrastructures, its innovative wire mesh system combines structural strength with installation flexibility—supporting efficient deployment across commercial, industrial, and mission-critical environments.',
  ];

  const partnerEls = Array.from(document.querySelectorAll('.partner-logo'));
  const logoSrcs   = partnerEls.map(el => el.querySelector('img').src);
  const logoAlts   = partnerEls.map(el => el.querySelector('img').alt);

  const modalLogo = modal.querySelector('.partner-modal__logo');
  const modalText = modal.querySelector('.partner-modal__text');
  const prevBtn   = modal.querySelector('.partner-modal__arrow--prev');
  const nextBtn   = modal.querySelector('.partner-modal__arrow--next');
  const closeBtn  = modal.querySelector('.partner-modal__close');

  let current = 0;

  function render(index) {
    current = (index + descriptions.length) % descriptions.length;
    modalLogo.src = logoSrcs[current];
    modalLogo.alt = logoAlts[current];
    modalText.textContent = descriptions[current];
  }

  function open(index) {
    render(index);
    modal.setAttribute('aria-hidden', 'false');
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }

  function close() {
    modal.setAttribute('aria-hidden', 'true');
    modal.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  partnerEls.forEach((el, i) => {
    el.addEventListener('click', () => {
      if (window.innerWidth >= 1024) return;
      open(i);
    });
  });

  document.querySelector('.partners__cta a')?.addEventListener('click', e => {
    if (window.innerWidth >= 1024) return;
    e.preventDefault();
    open(0);
  });

  prevBtn.addEventListener('click', () => render(current - 1));
  nextBtn.addEventListener('click', () => render(current + 1));
  closeBtn.addEventListener('click', close);
  modal.addEventListener('click', e => { if (e.target === modal) close(); });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && modal.classList.contains('is-open')) close();
  });
})();

// ─── About page carousel ──────────────────────────────────────────────────────

(function () {
  const carousel = document.querySelector('[data-about-carousel]');
  if (!carousel) return;

  const slides = carousel.querySelectorAll('.about-carousel__slide');
  const dots   = carousel.querySelectorAll('.about-carousel__dot');
  if (slides.length < 2) return;

  let current = 0;
  let timer;

  function goTo(index) {
    slides[current].classList.remove('is-active');
    dots[current].classList.remove('is-active');
    dots[current].setAttribute('aria-selected', 'false');
    current = index;
    slides[current].classList.add('is-active');
    dots[current].classList.add('is-active');
    dots[current].setAttribute('aria-selected', 'true');
  }

  function advance() {
    goTo((current + 1) % slides.length);
  }

  function resetTimer() {
    clearInterval(timer);
    timer = setInterval(advance, 5000);
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => { goTo(i); resetTimer(); });
  });

  timer = setInterval(advance, 5000);
})();

// ─── Hero slideshow (fade transition) ─────────────────────────────────────────

(function () {
  const slides = document.querySelectorAll('[data-hero] .hero__bg');
  if (slides.length < 2) return;

  let current = 0;

  setInterval(() => {
    slides[current].classList.remove('is-active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('is-active');
  }, 5000);
})();
