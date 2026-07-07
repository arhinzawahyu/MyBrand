// ===== DARK MODE =====
(function() {
  const saved = localStorage.getItem('langgarboy_dark');
  if (saved === 'true') document.documentElement.classList.add('dark');

  function setDark(isDark) {
    document.documentElement.classList.toggle('dark', isDark);
    localStorage.setItem('langgarboy_dark', isDark);
    const icons = document.querySelectorAll('#darkIcon, #darkIconMobile');
    icons.forEach(el => el.textContent = isDark ? '🌙' : '☀️');
  }

  document.querySelectorAll('#darkToggle, #darkToggleMobile').forEach(btn => {
    if (btn) btn.addEventListener('click', () => {
      const isDark = document.documentElement.classList.contains('dark');
      setDark(!isDark);
    });
  });

  const isDark = document.documentElement.classList.contains('dark');
  setDark(isDark);
})();

// ===== MOBILE MENU =====
(function() {
  const menu = document.getElementById('mobileMenu');
  const openBtn = document.getElementById('menuBtn');
  const closeBtn = document.getElementById('closeMenuBtn');

  function openMenu() {
    menu.classList.add('show');
    document.body.style.overflow = 'hidden';
    document.getElementById('navbar').classList.add('scrolled');
  }

  function closeMenu() {
    menu.classList.remove('show');
    document.body.style.overflow = '';
    if (window.scrollY <= 40) {
      document.getElementById('navbar').classList.remove('scrolled');
    }
  }

  if (openBtn) openBtn.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  document.querySelectorAll('#mobileMenu .nav-link').forEach(link => {
    link.addEventListener('click', closeMenu);
  });
})();

// ===== NAVBAR SCROLL =====
(function() {
  let ticking = false;
  window.addEventListener('scroll', () => {
    if (!ticking) {
      requestAnimationFrame(() => {
        const navbar = document.getElementById('navbar');
        if (navbar) {
          const menuOpen = document.getElementById('mobileMenu')?.classList.contains('show');
          navbar.classList.toggle('scrolled', window.scrollY > 40 || menuOpen);
        }
        ticking = false;
      });
      ticking = true;
    }
  }, { passive: true });
})();

// ===== HERO CAROUSEL =====
(function() {
  const slides = [
    { image: 'https://images.unsplash.com/photo-1607345366928-5ea672c38765?w=1200&q=80', title: 'DROP 001', subtitle: 'Tersedia sekarang' },
    { image: 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1200&q=80', title: 'SILHOUETTE TEE', subtitle: 'Pre-order sekarang' },
    { image: 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=1200&q=80', title: 'CARGO PANT', subtitle: 'Limited stock' },
  ];

  const bg = document.getElementById('heroBg');
  const title = document.getElementById('heroTitle');
  const subtitle = document.getElementById('heroSubtitle');
  const dots = document.getElementById('heroDots');

  if (!bg) return;

  let current = 0;

  slides.forEach((_, i) => {
    const dot = document.createElement('button');
    dot.className = `w-2 h-2 rounded-full transition-all duration-500 ${i === 0 ? 'active bg-white w-8' : 'bg-white/40'}`;
    dot.addEventListener('click', () => goTo(i));
    dots.appendChild(dot);
  });

  function goTo(index) {
    if (index === current) return;
    current = index;
    const s = slides[current];

    bg.style.opacity = '0';
    setTimeout(() => {
      bg.style.backgroundImage = `url(${s.image})`;
      bg.style.opacity = '1';
    }, 150);
    title.textContent = s.title;
    subtitle.textContent = s.subtitle;

    document.querySelectorAll('#heroDots button').forEach((d, i) => {
      d.className = `w-2 h-2 rounded-full transition-all duration-500 ${i === current ? 'active bg-white w-8' : 'bg-white/40'}`;
    });
  }

  bg.style.backgroundImage = `url(${slides[0].image})`;
  title.textContent = slides[0].title;
  subtitle.textContent = slides[0].subtitle;

  setInterval(() => goTo((current + 1) % slides.length), 5000);
})();

// ===== SCROLL REVEAL =====
(function() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '-60px' });

  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
})();

// ===== FAQ ACCORDION =====
(function() {
  document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.faq-item');
      const answer = item.querySelector('.faq-answer');
      const icon = btn.querySelector('.faq-icon');
      const isOpen = answer.classList.contains('open');

      document.querySelectorAll('.faq-answer.open').forEach(a => {
        a.classList.remove('open');
        a.closest('.faq-item').querySelector('.faq-icon').classList.remove('rotate');
      });

      if (!isOpen) {
        answer.classList.add('open');
        icon.classList.add('rotate');
      }
    });
  });
})();

// ===== CART (add to cart from product page) =====
(function() {
  const addBtn = document.getElementById('addToCartBtn');
  if (addBtn && typeof productData !== 'undefined') {
    let selectedColor = null;
    let selectedSize = null;

    document.querySelectorAll('.color-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.color-btn').forEach(b => {
          b.className = b.className.replace('border-stone-900 dark:border-stone-100 scale-110', 'border-stone-300 dark:border-stone-600');
        });
        btn.className = btn.className.replace('border-stone-300 dark:border-stone-600', 'border-stone-900 dark:border-stone-100 scale-110');
        selectedColor = btn.dataset.name;
      });
    });
    selectedColor = document.querySelector('.color-btn')?.dataset?.name || null;

    document.querySelectorAll('.size-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.size-btn').forEach(b => {
          b.className = b.className.replace('bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900', 'text-stone-600 dark:text-stone-400');
          b.style.borderColor = '';
          b.style.backgroundColor = '';
        });
        btn.style.backgroundColor = '';
        btn.className = 'size-btn min-w-[48px] h-10 text-xs uppercase tracking-[0.1em] border transition-all bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 border-stone-900 dark:border-stone-100';
        selectedSize = btn.dataset.size;
      });
    });

    let qty = 1;
    const qtyDisplay = document.getElementById('qtyDisplay');
    document.getElementById('qtyMinus')?.addEventListener('click', () => {
      qty = Math.max(1, qty - 1);
      qtyDisplay.textContent = qty;
    });
    document.getElementById('qtyPlus')?.addEventListener('click', () => {
      qty++;
      qtyDisplay.textContent = qty;
    });

    addBtn.addEventListener('click', () => {
      if (!selectedSize && productData.id !== 3 && productData.id !== 6) {
        alert('Pilih size dulu!');
        return;
      }

      const cart = JSON.parse(localStorage.getItem('langgarboy_cart') || '[]');
      cart.push({
        product_id: productData.id,
        name: productData.name,
        price: productData.price,
        size: selectedSize || 'One Size',
        color: selectedColor || '',
        quantity: qty,
        slug: productData.slug,
      });
      localStorage.setItem('langgarboy_cart', JSON.stringify(cart));
      alert('Ditambahkan ke keranjang!');
    });
  }
})();

// ===== QUANTITY BUTTONS (product page standalone) =====
(function() {
  const minus = document.getElementById('qtyMinus');
  const plus = document.getElementById('qtyPlus');
  const display = document.getElementById('qtyDisplay');
  if (minus && plus && display) {
    let qty = 1;
    minus.addEventListener('click', () => { qty = Math.max(1, qty - 1); display.textContent = qty; });
    plus.addEventListener('click', () => { qty++; display.textContent = qty; });
  }
})();
