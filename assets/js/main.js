/**
 * Century Printograph – Main JavaScript
 * Developed by: Waybig Technologies
 * Features: Navbar scroll, mobile menu, scroll animations,
 *           counter animation, back-to-top, gallery lightbox
 */

/* ═══════════════════════════════════════════════════════════════════════════
   DOM READY
   ═══════════════════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileMenu();
  initScrollAnimations();
  initCounters();
  initBackToTop();
  setActiveNavLink();
  initParticleCanvas();
  initCardTilt();
  initNotebookEffects();
});

/* ═══════════════════════════════════════════════════════════════════════════
   1. NAVBAR – scroll effect
   ═══════════════════════════════════════════════════════════════════════════ */
function initNavbar() {
  const navbar = document.getElementById('navbar');
  if (!navbar) return;

  const onScroll = () => {
    if (window.scrollY > 60) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll(); // Run on load
}

/* ═══════════════════════════════════════════════════════════════════════════
   2. MOBILE MENU – hamburger toggle
   ═══════════════════════════════════════════════════════════════════════════ */
function initMobileMenu() {
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobile-menu');

  if (!hamburger || !mobileMenu) return;

  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('open');
    mobileMenu.classList.toggle('open');
  });

  // Close on mobile link click
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      hamburger.classList.remove('open');
      mobileMenu.classList.remove('open');
    });
  });

  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
      hamburger.classList.remove('open');
      mobileMenu.classList.remove('open');
    }
  });
}

/* ═══════════════════════════════════════════════════════════════════════════
   3. ACTIVE NAV LINK – highlight current page
   ═══════════════════════════════════════════════════════════════════════════ */
function setActiveNavLink() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';

  document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (!href) return;

    const linkPage = href.split('/').pop();

    if (
      linkPage === currentPage ||
      (currentPage === '' && linkPage === 'index.html') ||
      (currentPage === 'contact.php' && linkPage === 'contact.php')
    ) {
      link.classList.add('active');
    }
  });
}

/* ═══════════════════════════════════════════════════════════════════════════
   4. SCROLL ANIMATIONS – Intersection Observer
   ═══════════════════════════════════════════════════════════════════════════ */
function initScrollAnimations() {
  const animatedEls = document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right');

  if (!animatedEls.length) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target); // Animate only once
        }
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
  );

  animatedEls.forEach(el => observer.observe(el));
}

/* ═══════════════════════════════════════════════════════════════════════════
   5. COUNTER ANIMATION – animates numbers up from 0
   ═══════════════════════════════════════════════════════════════════════════ */
function initCounters() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 }
  );

  counters.forEach(el => observer.observe(el));
}

function animateCounter(el) {
  const target = parseInt(el.getAttribute('data-count'), 10);
  const suffix = el.getAttribute('data-suffix') || '';
  const duration = 2000; // ms
  const start = performance.now();

  const tick = (now) => {
    const elapsed = now - start;
    const progress = Math.min(elapsed / duration, 1);
    // Ease-out cubic
    const eased = 1 - Math.pow(1 - progress, 3);
    const current = Math.round(eased * target);

    el.textContent = current.toLocaleString() + suffix;

    if (progress < 1) {
      requestAnimationFrame(tick);
    } else {
      el.textContent = target.toLocaleString() + suffix;
    }
  };

  requestAnimationFrame(tick);
}

/* ═══════════════════════════════════════════════════════════════════════════
   6. BACK TO TOP BUTTON
   ═══════════════════════════════════════════════════════════════════════════ */
function initBackToTop() {
  const btn = document.getElementById('back-to-top');
  if (!btn) return;

  window.addEventListener(
    'scroll',
    () => {
      btn.classList.toggle('show', window.scrollY > 400);
    },
    { passive: true }
  );

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/* ═══════════════════════════════════════════════════════════════════════════
   7. SIMPLE LIGHTBOX for gallery images
   ═══════════════════════════════════════════════════════════════════════════ */
(function initLightbox() {
  document.addEventListener('DOMContentLoaded', () => {
    const galleryItems = document.querySelectorAll('.gallery-item');
    if (!galleryItems.length) return;

    // Create overlay
    const overlay = document.createElement('div');
    overlay.id = 'lightbox-overlay';
    Object.assign(overlay.style, {
      display: 'none', position: 'fixed', inset: '0',
      background: 'rgba(0,0,0,0.92)', zIndex: '9999',
      alignItems: 'center', justifyContent: 'center',
      padding: '20px', cursor: 'zoom-out'
    });

    const img = document.createElement('img');
    Object.assign(img.style, {
      maxWidth: '90vw', maxHeight: '85vh',
      borderRadius: '10px', boxShadow: '0 20px 60px rgba(0,0,0,0.5)',
      objectFit: 'contain'
    });

    const closeBtn = document.createElement('button');
    closeBtn.textContent = '✕';
    Object.assign(closeBtn.style, {
      position: 'fixed', top: '20px', right: '24px',
      background: 'rgba(255,255,255,0.15)', border: 'none',
      color: '#fff', fontSize: '1.4rem', cursor: 'pointer',
      width: '42px', height: '42px', borderRadius: '50%',
      display: 'flex', alignItems: 'center', justifyContent: 'center'
    });

    overlay.append(img, closeBtn);
    document.body.appendChild(overlay);

    const open = (src) => { img.src = src; overlay.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
    const close = () => { overlay.style.display = 'none'; document.body.style.overflow = ''; };

    galleryItems.forEach(item => {
      item.addEventListener('click', () => {
        const src = item.querySelector('img')?.src;
        if (src) open(src);
      });
    });

    closeBtn.addEventListener('click', (e) => { e.stopPropagation(); close(); });
    overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
  });
})();

/* ═══════════════════════════════════════════════════════════════════════════
   8. CONTACT FORM – client-side validation
   ═══════════════════════════════════════════════════════════════════════════ */
(function initContactForm() {
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
      let valid = true;

      // Clear old errors
      form.querySelectorAll('.field-error').forEach(el => el.remove());
      form.querySelectorAll('.form-input').forEach(el => el.style.borderColor = '');

      // Required field validation
      form.querySelectorAll('[required]').forEach(input => {
        if (!input.value.trim()) {
          valid = false;
          showFieldError(input, 'This field is required.');
        }
      });

      // Email validation
      const emailInput = form.querySelector('[type="email"]');
      if (emailInput && emailInput.value.trim()) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value.trim())) {
          valid = false;
          showFieldError(emailInput, 'Please enter a valid email address.');
        }
      }

      // Phone validation (basic)
      const phoneInput = form.querySelector('[name="phone"]');
      if (phoneInput && phoneInput.value.trim()) {
        const digits = phoneInput.value.replace(/\D/g, '');
        if (digits.length < 10) {
          valid = false;
          showFieldError(phoneInput, 'Please enter a valid 10-digit phone number.');
        }
      }

      if (!valid) {
        e.preventDefault();
        // Scroll to first error
        const firstError = form.querySelector('.field-error');
        if (firstError) {
          firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }
    });
  });

  function showFieldError(input, message) {
    input.style.borderColor = '#DC2626';
    const error = document.createElement('p');
    error.className = 'field-error';
    error.style.cssText = 'color:#DC2626;font-size:0.8rem;margin-top:4px;';
    error.textContent = message;
    input.parentNode.appendChild(error);
  }
})();

/* ═══════════════════════════════════════════════════════════════════════════
   9. 3D PARTICLE CANVAS — animated floating particles with connections
   ═══════════════════════════════════════════════════════════════════════════ */
function initParticleCanvas() {
  // Find the hero or page-hero section
  const heroSection = document.querySelector('.hero') || document.querySelector('.page-hero');
  if (!heroSection) return;

  const canvas = document.createElement('canvas');
  canvas.id = 'particle-canvas';
  heroSection.insertBefore(canvas, heroSection.firstChild);

  const ctx = canvas.getContext('2d');
  let width, height, particles, mouseX = -1000, mouseY = -1000;
  const PARTICLE_COUNT = 80;
  const CONNECTION_DIST = 120;
  const MOUSE_DIST = 180;

  function resize() {
    width = canvas.width = heroSection.offsetWidth;
    height = canvas.height = heroSection.offsetHeight;
  }

  function createParticles() {
    particles = [];
    for (let i = 0; i < PARTICLE_COUNT; i++) {
      particles.push({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * 0.6,
        vy: (Math.random() - 0.5) * 0.6,
        radius: Math.random() * 2.5 + 1,
        opacity: Math.random() * 0.6 + 0.3,
        color: Math.random() > 0.6 ? 'rgba(255,140,0,' : 'rgba(74,144,226,'
      });
    }
  }

  function draw() {
    ctx.clearRect(0, 0, width, height);

    // Draw connections
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < CONNECTION_DIST) {
          const alpha = (1 - dist / CONNECTION_DIST) * 0.2;
          ctx.beginPath();
          ctx.strokeStyle = `rgba(74,144,226,${alpha})`;
          ctx.lineWidth = 0.6;
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }

    // Draw particles & mouse connections
    particles.forEach(p => {
      // Mouse interaction
      const mdx = p.x - mouseX;
      const mdy = p.y - mouseY;
      const mDist = Math.sqrt(mdx * mdx + mdy * mdy);
      if (mDist < MOUSE_DIST) {
        const alpha = (1 - mDist / MOUSE_DIST) * 0.4;
        ctx.beginPath();
        ctx.strokeStyle = `rgba(255,140,0,${alpha})`;
        ctx.lineWidth = 0.8;
        ctx.moveTo(p.x, p.y);
        ctx.lineTo(mouseX, mouseY);
        ctx.stroke();
      }

      // Draw particle
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
      ctx.fillStyle = p.color + p.opacity + ')';
      ctx.fill();

      // Move particle
      p.x += p.vx;
      p.y += p.vy;

      // Bounce off edges
      if (p.x < 0 || p.x > width) p.vx *= -1;
      if (p.y < 0 || p.y > height) p.vy *= -1;
    });

    requestAnimationFrame(draw);
  }

  // Mouse tracking
  heroSection.addEventListener('mousemove', (e) => {
    const rect = heroSection.getBoundingClientRect();
    mouseX = e.clientX - rect.left;
    mouseY = e.clientY - rect.top;
  });

  heroSection.addEventListener('mouseleave', () => {
    mouseX = -1000;
    mouseY = -1000;
  });

  window.addEventListener('resize', () => {
    resize();
    createParticles();
  });

  resize();
  createParticles();
  draw();
}

/* ═══════════════════════════════════════════════════════════════════════════
   10. CARD TILT EFFECT — subtle 3D perspective tilt on hover
   ═══════════════════════════════════════════════════════════════════════════ */
function initCardTilt() {
  const cards = document.querySelectorAll('.product-card, .card, .machine-card, .value-card');
  if (!cards.length) return;

  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = ((y - centerY) / centerY) * -4; // max 4deg
      const rotateY = ((x - centerX) / centerX) * 4;

      card.style.transform = `perspective(600px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });
}

/* ═══════════════════════════════════════════════════════════════════════════
   11. NOTEBOOK THEME EFFECTS — stationery-feel enhancements
   ═══════════════════════════════════════════════════════════════════════════ */
function initNotebookEffects() {
  // A) Page-turn hover sound effect via subtle shadow shift (CSS driven via nb-page-hover)
  // Already handled by CSS class .nb-page-hover — no JS override needed.

  // B) Enhanced paper card tilt — override the generic tilt for nb-page-hover cards
  //    to add the characteristic slight rotation like a real sheet of paper
  const paperCards = document.querySelectorAll('.nb-page-hover');
  paperCards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      // Very subtle rotation to mimic paper lift
      const rotateX = ((y - centerY) / centerY) * -2;
      const rotateY = ((x - centerX) / centerX) * 2;
      const rotate = ((x - centerX) / centerX) * -0.5;

      card.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) rotate(${rotate}deg) translateY(-8px)`;
      card.style.boxShadow = '8px 14px 38px rgba(0,0,0,0.10), 0 0 0 1px rgba(210,195,165,0.2)';
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
    });
  });

  // C) Animate spiral dots on scroll — add a subtle entrance
  const spiralCards = document.querySelectorAll('.nb-spiral-dots');
  if (spiralCards.length) {
    const spiralObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.setProperty('--spiral-opacity', '1');
            spiralObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.3 }
    );
    spiralCards.forEach(el => spiralObserver.observe(el));
  }

  // D) Add paper-texture class to stacked cards on hover — lift effect
  const stackedCards = document.querySelectorAll('.nb-stacked');
  stackedCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transform = 'translateY(-4px) rotate(-0.3deg)';
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });
}
