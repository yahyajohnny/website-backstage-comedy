/* ============================================================
   BACKSTAGE COMEDY NIGHT – main.js
   ============================================================ */

'use strict';

const API_URL = '/api-events.php';
let allEvents = [];
let matomoLoaded = false;

function prefersReducedMotion() {
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

// ── CONSENT + MATOMO (once per page) ──
function getConsent() {
  try {
    return localStorage.getItem('bcn_matomo_consent');
  } catch (e) {
    return null;
  }
}

function setConsent(value) {
  try {
    localStorage.setItem('bcn_matomo_consent', value);
  } catch (e) { /* ignore */ }
}

function loadMatomo() {
  if (matomoLoaded) return;
  if (!window.BCN_MATOMO || !window.BCN_MATOMO.url || !window.BCN_MATOMO.siteId) return;
  matomoLoaded = true;

  window._paq = window._paq || [];
  const _paq = window._paq;
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  const u = window.BCN_MATOMO.url;
  _paq.push(['setTrackerUrl', u + 'matomo.php']);
  _paq.push(['setSiteId', window.BCN_MATOMO.siteId]);
  const g = document.createElement('script');
  g.async = true;
  g.src = u + 'matomo.js';
  document.head.appendChild(g);
}

function trackTicketClick(slugOrName) {
  if (!matomoLoaded || !window._paq) return;
  window._paq.push(['trackEvent', 'Ticket', 'Click', String(slugOrName || 'unknown')]);
}

function initConsent() {
  const banner = document.getElementById('cookie-banner');
  const accept = document.getElementById('cookie-accept');
  const decline = document.getElementById('cookie-decline');
  const consent = getConsent();

  if (consent === '1') {
    loadMatomo();
    if (banner) banner.hidden = true;
    return;
  }
  if (consent === '0') {
    if (banner) banner.hidden = true;
    return;
  }

  if (banner) {
    banner.hidden = false;
    banner.classList.add('visible');
  }
  if (accept) {
    accept.addEventListener('click', () => {
      setConsent('1');
      if (banner) {
        banner.classList.remove('visible');
        banner.hidden = true;
      }
      loadMatomo();
    });
  }
  if (decline) {
    decline.addEventListener('click', () => {
      setConsent('0');
      if (banner) {
        banner.classList.remove('visible');
        banner.hidden = true;
      }
    });
  }
}

function initTicketTracking() {
  document.addEventListener('click', (e) => {
    const link = e.target.closest('a.js-ticket-link, a[href*="snapticket.de"]');
    if (!link) return;
    const name = link.getAttribute('data-ticket-slug')
      || link.getAttribute('data-ticket-name')
      || link.getAttribute('href');
    trackTicketClick(name);
  });
}

// ── PRELOADER (non-blocking, short, skip if reduced motion / revisit) ──
function initPreloader() {
  const preloader = document.getElementById('preloader');
  if (!preloader) return;

  const hasVisited = sessionStorage.getItem('bcn_visited');
  if (hasVisited || prefersReducedMotion()) {
    preloader.style.display = 'none';
    return;
  }

  const logo = preloader.querySelector('.preloader-logo');
  requestAnimationFrame(() => logo && logo.classList.add('show'));
  setTimeout(() => {
    preloader.classList.add('hide');
    setTimeout(() => {
      preloader.style.display = 'none';
    }, 400);
  }, 400);

  sessionStorage.setItem('bcn_visited', '1');
}

// ── CUSTOM CURSOR ──
function initCursor() {
  if (prefersReducedMotion()) return;
  const isTouch = window.matchMedia('(pointer: coarse)').matches;
  if (isTouch) return;

  const dot = document.createElement('div');
  dot.className = 'cursor-dot';
  const ring = document.createElement('div');
  ring.className = 'cursor-ring';
  document.body.append(dot, ring);

  let ringX = 0, ringY = 0, mouseX = 0, mouseY = 0;
  document.addEventListener('mousemove', e => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    dot.style.left = mouseX + 'px';
    dot.style.top = mouseY + 'px';
  }, { passive: true });

  function animateRing() {
    ringX += (mouseX - ringX) * 0.12;
    ringY += (mouseY - ringY) * 0.12;
    ring.style.left = ringX + 'px';
    ring.style.top = ringY + 'px';
    requestAnimationFrame(animateRing);
  }
  animateRing();
}

// ── NAVIGATION ──
function initNavigation() {
  const nav = document.querySelector('.nav');
  if (!nav) return;

  const onScroll = () => {
    if (!nav.classList.contains('scrolled') || window.scrollY > 60) {
      nav.classList.toggle('scrolled', window.scrollY > 60 || document.body.classList.contains('subpage'));
    }
    updateActiveNavLink();
  };
  window.addEventListener('scroll', onScroll, { passive: true });

  const hamburger = document.querySelector('.nav-hamburger');
  const overlay = document.querySelector('.nav-overlay');
  if (hamburger && overlay) {
    hamburger.addEventListener('click', () => {
      const isOpen = overlay.classList.toggle('open');
      hamburger.classList.toggle('open', isOpen);
      hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });
    overlay.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        overlay.classList.remove('open');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });
  }
}

function updateActiveNavLink() {
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');
  if (!navLinks.length) return;
  let current = '';
  sections.forEach(sec => {
    if (window.scrollY >= sec.offsetTop - 120) current = sec.id;
  });
  navLinks.forEach(link => {
    const href = link.getAttribute('href').slice(1);
    link.classList.toggle('active', href === current);
  });
}

function initHeroAnimation() {
  if (prefersReducedMotion()) return;
  const title = document.querySelector('.hero-title');
  if (!title) return;
  const lines = title.querySelectorAll('.hero-line');
  lines.forEach((line, lineIdx) => {
    const text = line.textContent;
    line.textContent = '';
    const words = text.split(' ');
    words.forEach((word, wordIdx) => {
      const wrapper = document.createElement('span');
      wrapper.className = 'word-wrapper';
      const inner = document.createElement('span');
      inner.className = 'word';
      inner.textContent = word + (wordIdx < words.length - 1 ? '\u00a0' : '');
      inner.style.animationDelay = `${(lineIdx * words.length + wordIdx) * 0.08 + 0.2}s`;
      wrapper.appendChild(inner);
      line.appendChild(wrapper);
    });
  });
}

function initScrollReveal() {
  const els = document.querySelectorAll('.reveal');
  if (!els.length) return;
  if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
    els.forEach(el => el.classList.add('visible'));
    return;
  }
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  els.forEach(el => observer.observe(el));
}

function initFAQ() {
  document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.faq-item');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(i => {
        i.classList.remove('open');
        i.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
        const ans = i.querySelector('.faq-answer');
        if (ans) ans.style.maxHeight = null;
      });
      if (!isOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
        const answer = item.querySelector('.faq-answer');
        if (answer) answer.style.maxHeight = answer.scrollHeight + 'px';
      }
    });
  });
}

function initParallax() {
  const heroContent = document.querySelector('.hero-content');
  if (!heroContent || prefersReducedMotion()) return;
  let ticking = false;
  window.addEventListener('scroll', () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => {
      const scrolled = window.scrollY;
      if (scrolled < window.innerHeight) {
        heroContent.style.transform = `translateY(${scrolled * 0.2}px)`;
      }
      ticking = false;
    });
  }, { passive: true });
}

function initMapLoader() {
  const btn = document.getElementById('loadMapBtn');
  const wrap = document.getElementById('mapWrap');
  const tpl = document.getElementById('mapTemplate');
  if (!btn || !wrap || !tpl) return;
  btn.addEventListener('click', () => {
    wrap.innerHTML = '';
    wrap.appendChild(tpl.content.cloneNode(true));
  });
}

// ── EVENTS ──
function eventStillRelevant(event) {
  const end = event.end ? new Date(event.end) : new Date(new Date(event.start).getTime() + 3 * 60 * 60 * 1000);
  return end > new Date();
}

async function loadShows() {
  const grid = document.getElementById('showsGrid');
  const serverRendered = grid && grid.dataset.ssr === '1';

  try {
    const res = await fetch(API_URL, { credentials: 'same-origin' });
    if (!res.ok) throw new Error(`API ${res.status}`);
    allEvents = await res.json();

    if (grid && serverRendered) {
      const firstApi = allEvents[0] || null;
      const ssrSlug = grid.dataset.firstSlug || '';
      const ssrEnd = grid.dataset.firstEnd || '';
      const ssrEnded = ssrEnd ? new Date(ssrEnd) <= new Date() : false;
      const mismatch = firstApi && ssrSlug && firstApi.slug !== ssrSlug;
      if (ssrEnded || mismatch || (ssrSlug && !firstApi)) {
        renderShowCards(grid, allEvents);
        grid.dataset.ssr = '0';
      }
    } else if (grid && !serverRendered) {
      renderShowCards(grid, allEvents);
    }

    // Compact lists on landing pages
    document.querySelectorAll('[data-event-list][data-ssr="1"]').forEach(list => {
      const first = list.querySelector('[data-event-end]');
      if (!first) return;
      const end = first.getAttribute('data-event-end');
      const slug = first.getAttribute('data-event-slug');
      const ended = end && new Date(end) <= new Date();
      const mismatch = allEvents[0] && slug && allEvents[0].slug !== slug;
      if (ended || mismatch) {
        // Soft fallback: reload page section from API by replacing with cards if homepage-style grid absent
        // Landing pages keep link to /termine/ if stale
        const note = document.createElement('p');
        note.className = 'ssr-refresh-note';
        note.innerHTML = 'Die Terminliste wurde aktualisiert. <a href="/termine/">Aktuelle Termine ansehen</a>.';
        list.prepend(note);
        // Force re-render of show grids only; for event-list pages redirecting note is enough
      }
    });

    initCountdown();
  } catch (err) {
    console.error('Event-Endpunkt Fehler:', err);
    if (grid && !serverRendered) renderShowsFallback(grid);
  }
}

let countdownInterval = null;
let countdownTarget = null;

function initCountdown() {
  const el = document.getElementById('heroCountdown');
  if (!el) return;
  if (countdownInterval) clearInterval(countdownInterval);
  tickCountdown();
  countdownInterval = setInterval(tickCountdown, 1000);
}

function getCountdownEvent() {
  return allEvents.find(eventStillRelevant) || null;
}

function setCountdownEvent(event) {
  const el = document.getElementById('heroCountdown');
  const label = document.getElementById('countdownLabel');
  const cta = document.getElementById('countdownCta');
  if (!el || !label || !cta) return;
  countdownTarget = event;
  const dateStr = new Date(event.start).toLocaleDateString('de-DE', {
    day: '2-digit', month: 'long', timeZone: 'Europe/Berlin'
  });
  label.textContent = `Nächste Show am ${dateStr} · Countdown läuft`;
  if (event.soldOut) {
    cta.textContent = 'Ausverkauft – alle Termine ansehen →';
    el.href = '/termine/';
    el.removeAttribute('target');
    el.removeAttribute('rel');
  } else {
    cta.textContent = 'Tickets sichern →';
    el.href = event.ticketUrl;
    el.target = '_blank';
    el.rel = 'noopener noreferrer';
    el.classList.add('js-ticket-link');
    el.setAttribute('data-ticket-slug', event.slug || '');
  }
}

function tickCountdown() {
  const el = document.getElementById('heroCountdown');
  if (!el) return;
  const event = getCountdownEvent();
  if (!event) {
    el.hidden = true;
    if (countdownInterval) clearInterval(countdownInterval);
    return;
  }
  if (event !== countdownTarget) setCountdownEvent(event);
  const now = new Date();
  const start = new Date(event.start);
  const label = document.getElementById('countdownLabel');
  const timer = document.getElementById('countdownTimer');
  if (start <= now) {
    el.classList.add('is-live');
    if (label) label.textContent = 'Die Show läuft gerade – bis gleich!';
    if (timer) timer.style.display = 'none';
    el.hidden = false;
    return;
  }
  el.classList.remove('is-live');
  if (timer) timer.style.display = '';
  let diff = Math.floor((start - now) / 1000);
  const days = Math.floor(diff / 86400); diff %= 86400;
  const hours = Math.floor(diff / 3600); diff %= 3600;
  const mins = Math.floor(diff / 60);
  const secs = diff % 60;
  const d = document.getElementById('cdDays');
  const h = document.getElementById('cdHours');
  const m = document.getElementById('cdMins');
  const s = document.getElementById('cdSecs');
  if (d) d.textContent = String(days);
  if (h) h.textContent = String(hours).padStart(2, '0');
  if (m) m.textContent = String(mins).padStart(2, '0');
  if (s) s.textContent = String(secs).padStart(2, '0');
  el.hidden = false;
}

function renderShowCards(grid, events) {
  grid.setAttribute('aria-busy', 'false');
  if (!events.length) {
    renderShowsFallback(grid);
    return;
  }
  grid.innerHTML = events.map(buildShowCard).join('');
  initScrollReveal();
}

function buildShowCard(event) {
  const start = new Date(event.start);
  const doors = new Date(event.doors);
  const now = new Date();
  const isToday = start.toLocaleDateString('en-CA', { timeZone: 'Europe/Berlin' })
    === now.toLocaleDateString('en-CA', { timeZone: 'Europe/Berlin' });

  let badge = '';
  if (event.soldOut) badge = '<span class="show-badge badge-soldout">Ausverkauft</span>';
  else if (isToday) badge = '<span class="show-badge badge-today">Heute!</span>';

  const img = event.image
    ? `<img src="${escHtml(event.image)}" alt="Backstage Comedy Night München – ${escHtml(formatFullDate(event.start))}" loading="lazy" width="1200" height="675" onerror="this.style.display='none'">`
    : '<div class="show-card-placeholder">Comedy</div>';

  const price = event.minPrice !== null && event.minPrice !== undefined
    ? `<div class="show-price">ab ${formatPrice(event.minPrice)} <span>€</span></div>`
    : '<div class="show-price">Tickets im Vorverkauf</div>';

  const cta = event.soldOut
    ? '<a href="/termine/" class="show-cta">Weitere Termine →</a>'
    : `<a href="${escHtml(event.ticketUrl)}" target="_blank" rel="noopener noreferrer" class="show-cta js-ticket-link" data-ticket-slug="${escHtml(event.slug)}">Tickets sichern →</a>`;

  return `
    <article class="show-card reveal" data-event-slug="${escHtml(event.slug)}" data-event-end="${escHtml(event.end)}" data-event-start="${escHtml(event.start)}">
      <div class="show-card-image">${img}${badge}</div>
      <div class="show-card-body">
        <div class="show-date">${formatShortDateFull(event.start)}</div>
        <div class="show-time">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Einlass ${formatTime(doors)} Uhr · Show ${formatTime(start)} Uhr
        </div>
        <div class="show-name">${escHtml(event.name)}</div>
        <div class="show-location">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          Backstage München
        </div>
        <div class="show-footer">${price}${cta}</div>
        <a href="/termine/${escHtml(event.slug)}/" class="event-detail-link">Alle Infos zur Show →</a>
      </div>
    </article>`;
}

function renderShowsFallback(grid) {
  grid.setAttribute('aria-busy', 'false');
  grid.innerHTML = `
    <div class="shows-empty">
      <p>Neue Termine kommen bald. Folge uns auf Instagram um nichts zu verpassen.</p>
      <a href="https://www.instagram.com/backstage.comedy.night/" target="_blank" rel="noopener noreferrer">@backstage.comedy.night →</a>
    </div>`;
}

function formatShortDateFull(iso) {
  return new Date(iso).toLocaleDateString('de-DE', {
    weekday: 'long', day: '2-digit', month: 'long', year: 'numeric', timeZone: 'Europe/Berlin'
  });
}
function formatFullDate(iso) {
  return new Date(iso).toLocaleDateString('de-DE', {
    day: '2-digit', month: '2-digit', year: 'numeric', timeZone: 'Europe/Berlin'
  });
}
function formatTime(iso) {
  return new Date(iso).toLocaleTimeString('de-DE', {
    hour: '2-digit', minute: '2-digit', timeZone: 'Europe/Berlin'
  });
}
function formatPrice(p) {
  return Number(p).toLocaleString('de-DE', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
}
function escHtml(str) {
  return String(str || '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', () => {
  initConsent();
  initTicketTracking();
  initPreloader();
  initCursor();
  initNavigation();
  initHeroAnimation();
  initScrollReveal();
  initFAQ();
  initParallax();
  initMapLoader();
  loadShows();
});
