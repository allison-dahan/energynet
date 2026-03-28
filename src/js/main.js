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

// ─── Products filter (sidebar + overlay) ──────────────────────────────────────

(function () {
  const cards = document.querySelectorAll('.product-card');
  if (!cards.length) return;

  const overlay  = document.querySelector('[data-filter-overlay]');
  const openBtn  = document.querySelector('[data-filter-open]');

  const activeFilters = { brand: 'all', category: 'all', search: '' };

  function applyFilters() {
    const term = activeFilters.search.toLowerCase();
    cards.forEach(card => {
      const brands     = (card.dataset.brands     || '').split(',').filter(Boolean);
      const categories = (card.dataset.categories || '').split(',').filter(Boolean);
      const title      = (card.querySelector('.product-card__title')?.textContent || '').toLowerCase();

      const brandMatch  = activeFilters.brand    === 'all' || brands.includes(activeFilters.brand);
      const catMatch    = activeFilters.category === 'all' || categories.includes(activeFilters.category);
      const searchMatch = !term || title.includes(term);

      card.classList.toggle('is-filter-hidden', !(brandMatch && catMatch && searchMatch));
    });
    document.dispatchEvent(new CustomEvent('productsFiltered'));
  }

  // Sync active class across ALL matching filter buttons (sidebar + overlay).
  function syncButtons(filterType, value) {
    document.querySelectorAll(`[data-filter="${filterType}"]`)
      .forEach(b => b.classList.remove('is-active'));
    document.querySelectorAll(`[data-filter="${filterType}"][data-value="${value}"]`)
      .forEach(b => b.classList.add('is-active'));
  }

  function openOverlay() {
    if (!overlay) return;
    overlay.classList.add('is-open');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeOverlay() {
    if (!overlay) return;
    overlay.classList.remove('is-open');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  openBtn?.addEventListener('click', openOverlay);

  overlay?.querySelectorAll('[data-filter-close]')
    .forEach(btn => btn.addEventListener('click', closeOverlay));

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && overlay?.classList.contains('is-open')) closeOverlay();
  });

  // Brand header elements.
  const introTitle   = document.querySelector('[data-intro-title]');
  const brandHeader  = document.querySelector('[data-brand-header]');
  const brandLogoImg = document.querySelector('[data-brand-logo-img]');
  const brandLabel   = document.querySelector('[data-brand-label]');
  const sidebar      = document.querySelector('.products-sidebar');

  function updateBrandHeader(value, btn) {
    if (!brandHeader) return;
    if (value === 'all') {
      brandHeader.setAttribute('aria-hidden', 'true');
      introTitle?.removeAttribute('hidden');
      sidebar?.classList.remove('is-filtered');
    } else {
      const logoSrc = btn?.dataset.brandLogo || '';
      const label   = btn?.dataset.brandLabel || value;
      if (brandLogoImg) {
        brandLogoImg.src = logoSrc;
        brandLogoImg.alt = label;
        brandLogoImg.hidden = !logoSrc;
      }
      if (brandLabel) brandLabel.textContent = label;
      brandHeader.setAttribute('aria-hidden', 'false');
      introTitle?.setAttribute('hidden', '');
      sidebar?.classList.add('is-filtered');
    }
  }

  // Global filter button handler — works for both sidebar and overlay buttons.
  document.addEventListener('click', e => {
    const item = e.target.closest('[data-filter]');
    if (!item) return;

    const filterType = item.dataset.filter;
    const value      = item.dataset.value;

    // "All Categories" resets all filters.
    if (filterType === 'category' && value === 'all') {
      activeFilters.brand    = 'all';
      activeFilters.category = 'all';
      syncButtons('brand', 'all');
      syncButtons('category', 'all');
      updateBrandHeader('all', null);
      applyFilters();
      if (overlay?.contains(item)) closeOverlay();
      return;
    }

    syncButtons(filterType, value);
    activeFilters[filterType] = value;
    applyFilters();

    if (filterType === 'brand') updateBrandHeader(value, item);

    // Close overlay only when clicking inside it.
    if (overlay?.contains(item)) closeOverlay();
  });

  // Sidebar search (desktop).
  document.querySelector('[data-sidebar-search]')?.addEventListener('input', e => {
    activeFilters.search = e.target.value;
    applyFilters();
  });

  // Overlay search (mobile).
  overlay?.querySelector('[data-filter-search]')?.addEventListener('input', e => {
    activeFilters.search = e.target.value;
    applyFilters();
  });
})();

// ─── Products pagination ───────────────────────────────────────────────────────

(function () {
  const paginationEl = document.querySelector('[data-products-pagination]');
  if (!paginationEl) return;

  const allCards = Array.from(document.querySelectorAll('.product-card'));
  if (!allCards.length) return;

  let currentPage = 1;

  function perPage() {
    return window.innerWidth >= 1024 ? 9 : 8;
  }

  function filteredCards() {
    return allCards.filter(c => !c.classList.contains('is-filter-hidden'));
  }

  function showPage(page) {
    const pp      = perPage();
    const visible = filteredCards();
    const total   = Math.ceil(visible.length / pp) || 1;
    currentPage   = Math.max(1, Math.min(page, total));

    const start = (currentPage - 1) * pp;
    const end   = start + pp;

    allCards.forEach(card => {
      if (card.classList.contains('is-filter-hidden')) {
        card.classList.remove('is-page-hidden');
        return;
      }
      const idx = visible.indexOf(card);
      card.classList.toggle('is-page-hidden', idx < start || idx >= end);
    });

    renderPagination(total);
  }

  function pageNumbers(current, total) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);

    if (current <= 4) {
      const pages = [1, 2, 3, 4, 5];
      if (total > 6) pages.push('...');
      for (let i = Math.max(total - 2, 6); i <= total; i++) pages.push(i);
      return pages;
    }

    if (current >= total - 3) {
      const pages = [1, 2, 3, '...'];
      for (let i = Math.min(total - 4, total - 4); i <= total; i++) pages.push(i);
      return pages;
    }

    return [1, 2, 3, '...', current - 1, current, current + 1, '...', total - 2, total - 1, total];
  }

  function renderPagination(total) {
    if (total <= 1) { paginationEl.innerHTML = ''; return; }

    let html = '';
    pageNumbers(currentPage, total).forEach(p => {
      if (p === '...') {
        html += '<span class="pagination__ellipsis" aria-hidden="true">...</span>';
      } else {
        const active = p === currentPage;
        html += `<button class="pagination__btn${active ? ' is-active' : ''}" data-page="${p}"${active ? ' aria-current="page"' : ''} aria-label="Page ${p}">${p}</button>`;
      }
    });

    if (currentPage < total) {
      html += `<button class="pagination__next" data-page="${currentPage + 1}" aria-label="Next page"><iconify-icon icon="ph:caret-right" width="13" height="24"></iconify-icon></button>`;
    }

    paginationEl.innerHTML = html;
  }

  paginationEl.addEventListener('click', e => {
    const btn = e.target.closest('[data-page]');
    if (!btn) return;
    showPage(parseInt(btn.dataset.page, 10));
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // Reset to page 1 whenever filters change.
  document.addEventListener('productsFiltered', () => showPage(1));

  // Re-paginate on viewport resize (9 ↔ 8 per page).
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => showPage(currentPage), 200);
  }, { passive: true });

  showPage(1);
})();

// ─── Back to top ───────────────────────────────────────────────────────────────

(function () {
  const btn = document.querySelector('[data-back-to-top]');
  if (!btn) return;

  window.addEventListener('scroll', () => {
    btn.classList.toggle('is-visible', window.scrollY > 300);
  }, { passive: true });

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
})();

// ─── Copy link ─────────────────────────────────────────────────────────────────

(function () {
  document.addEventListener('click', e => {
    const btn = e.target.closest('[data-copy-url]');
    if (!btn) return;

    const url = btn.dataset.copyUrl;
    if (!url) return;

    navigator.clipboard.writeText(url).then(() => {
      const icon = btn.querySelector('iconify-icon');
      if (icon) {
        const prev = icon.getAttribute('icon');
        icon.setAttribute('icon', 'mdi:check');
        setTimeout(() => icon.setAttribute('icon', prev), 1500);
      }
    });
  });
})();

// ─── Projects drawers ─────────────────────────────────────────────────────────

(function () {
  const drawers = document.querySelectorAll('.projects-drawer');
  if (!drawers.length) return;

  function openDrawer(id) {
    const drawer = document.getElementById(id);
    if (!drawer) return;
    drawer.classList.add('is-open');
    drawer.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer(drawer) {
    drawer.classList.remove('is-open');
    drawer.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    const list   = drawer.querySelector('.projects-drawer__list');
    const detail = drawer.querySelector('.projects-detail');
    if (list)   list.hidden   = false;
    if (detail) detail.hidden = true;
  }

  document.querySelectorAll('[data-drawer-open]').forEach(btn => {
    btn.addEventListener('click', () => openDrawer('drawer-' + btn.dataset.drawerOpen));
  });

  drawers.forEach(drawer => {
    drawer.querySelectorAll('[data-drawer-close]').forEach(el => {
      el.addEventListener('click', () => closeDrawer(drawer));
    });

    const list         = drawer.querySelector('.projects-drawer__list');
    const detail       = drawer.querySelector('.projects-detail');
    const cards        = Array.from(drawer.querySelectorAll('.project-card'));
    const paginationEl = drawer.querySelector('.projects-drawer__pagination');

    if (!list || !cards.length) return;

    const dataKey  = drawer.id === 'drawer-completed' ? 'projectsCompleted' : 'projectsOngoing';
    const projects = window[dataKey] || [];
    let currentPage = 1;

    function perPage() {
      return window.innerWidth >= 1024 ? 6 : 3;
    }

    function showPage(page) {
      const pp    = perPage();
      const total = Math.ceil(cards.length / pp) || 1;
      currentPage = Math.max(1, Math.min(page, total));

      const start = (currentPage - 1) * pp;
      const end   = start + pp;

      cards.forEach((card, i) => {
        card.hidden = i < start || i >= end;
      });

      renderPagination(total);
    }

    function renderPagination(total) {
      if (!paginationEl) return;
      if (total <= 1) { paginationEl.innerHTML = ''; return; }

      let html = '';
      for (let p = 1; p <= total; p++) {
        html += `<button class="drawer-page-btn${p === currentPage ? ' is-active' : ''}" data-page="${p}">${p}</button>`;
      }
      if (currentPage < total) {
        html += `<button class="drawer-page-next" data-page-next aria-label="Next page"><iconify-icon icon="ph:caret-right" width="10" height="18"></iconify-icon></button>`;
      }
      paginationEl.innerHTML = html;

      paginationEl.querySelectorAll('.drawer-page-btn').forEach(btn => {
        btn.addEventListener('click', () => showPage(parseInt(btn.dataset.page, 10)));
      });
      paginationEl.querySelector('[data-page-next]')?.addEventListener('click', () => showPage(currentPage + 1));
    }

    // ── Detail view ──
    if (detail) {
      const total     = projects.length;
      let current     = 0;

      const titleEl   = detail.querySelector('[data-detail-title]');
      const clientEl  = detail.querySelector('[data-detail-client]');
      const dateEl    = detail.querySelector('[data-detail-date]');
      const scopeEl   = detail.querySelector('[data-detail-scope]');
      const counterEl = detail.querySelector('[data-detail-counter]');
      const prevBtn   = detail.querySelector('[data-detail-prev]');
      const nextBtn   = detail.querySelector('[data-detail-next]');
      const panel     = drawer.querySelector('.projects-drawer__panel');

      function showDetail(index) {
        current = Math.max(0, Math.min(index, total - 1));
        const p = projects[current];
        if (!p) return;

        if (titleEl)   titleEl.textContent   = p.title;
        if (clientEl)  clientEl.textContent  = p.client;
        if (dateEl)    dateEl.textContent    = p.date;
        if (scopeEl)   scopeEl.textContent   = p.scope;
        if (counterEl) counterEl.textContent = `PROJECT ${current + 1} of ${total}`;
        if (prevBtn)   prevBtn.disabled = current === 0;
        if (nextBtn)   nextBtn.disabled = current === total - 1;

        list.hidden   = true;
        detail.hidden = false;
        if (panel) panel.scrollTop = 0;
      }

      cards.forEach((card, i) => {
        card.addEventListener('click', () => showDetail(i));
        card.addEventListener('keydown', e => {
          if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); showDetail(i); }
        });
      });

      prevBtn?.addEventListener('click', () => showDetail(current - 1));
      nextBtn?.addEventListener('click', () => showDetail(current + 1));
    }

    // Re-paginate on resize
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => showPage(currentPage), 200);
    }, { passive: true });

    showPage(1);
  });

  document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    const open = document.querySelector('.projects-drawer.is-open');
    if (open) closeDrawer(open);
  });
})();

