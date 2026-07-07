<?php
$current_page = basename($_SERVER['PHP_SELF']);
$categories = getCategories();
?>
<header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 bg-transparent">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-6 h-18">
    <a href="<?= SITE_URL ?>/" class="text-xl font-bold tracking-tight text-stone-900 dark:text-stone-100">
      LANGGAR<span class="text-signature">BOY</span>
    </a>

    <nav class="hidden md:flex items-center gap-8">
      <?php foreach ($categories as $cat): ?>
        <a href="<?= SITE_URL ?>/products.php?cat=<?= $cat['slug'] ?>"
           class="text-sm uppercase tracking-[0.15em] text-stone-600 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-100 transition-colors">
          <?= $cat['name'] ?>
        </a>
      <?php endforeach; ?>
      <a href="<?= SITE_URL ?>/products.php"
         class="text-sm uppercase tracking-[0.15em] text-stone-600 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-100 transition-colors">
        All
      </a>
      <a href="<?= SITE_URL ?>/admin/login.php" class="text-xs uppercase tracking-[0.15em] text-signature hover:text-signature-light transition-colors">Login</a>
      <button id="darkToggle" class="w-9 h-9 flex items-center justify-center rounded-full border border-stone-300 dark:border-stone-700 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors text-sm" aria-label="Toggle dark mode">
        <span id="darkIcon">☀️</span>
      </button>
    </nav>

    <button id="menuBtn" class="md:hidden relative w-8 h-8 flex items-center justify-center z-[60]" aria-label="Menu">
      <span class="menu-bar absolute block h-0.5 w-5 bg-stone-900 dark:bg-stone-100 transition-all duration-300 -translate-y-1.5"></span>
      <span class="menu-bar absolute block h-0.5 w-5 bg-stone-900 dark:bg-stone-100 transition-all duration-300"></span>
      <span class="menu-bar absolute block h-0.5 w-5 bg-stone-900 dark:bg-stone-100 transition-all duration-300 translate-y-1.5"></span>
    </button>
  </div>
</header>

<div id="mobileMenu" class="fixed inset-0 z-[55] md:hidden bg-white dark:bg-stone-950 flex-col items-center justify-center hidden">
  <button id="closeMenuBtn" class="absolute top-5 right-6 w-8 h-8 flex items-center justify-center z-[60]" aria-label="Close">
    <span class="absolute block h-0.5 w-5 bg-stone-900 dark:bg-stone-100 rotate-45"></span>
    <span class="absolute block h-0.5 w-5 bg-stone-900 dark:bg-stone-100 -rotate-45"></span>
  </button>
  <nav class="flex flex-col items-center gap-8">
    <a href="<?= SITE_URL ?>/" class="nav-link text-2xl uppercase tracking-[0.2em] font-medium text-stone-800 dark:text-stone-200 hover:text-signature transition-colors">Home</a>
    <?php foreach ($categories as $cat): ?>
      <a href="<?= SITE_URL ?>/products.php?cat=<?= $cat['slug'] ?>" class="nav-link text-2xl uppercase tracking-[0.2em] font-medium text-stone-800 dark:text-stone-200 hover:text-signature transition-colors"><?= $cat['name'] ?></a>
    <?php endforeach; ?>
    <a href="<?= SITE_URL ?>/products.php" class="nav-link text-2xl uppercase tracking-[0.2em] font-medium text-stone-800 dark:text-stone-200 hover:text-signature transition-colors">All</a>
    <a href="<?= SITE_URL ?>/admin/login.php" class="nav-link text-lg uppercase tracking-[0.2em] font-medium text-signature hover:text-signature-light transition-colors">Login</a>
    <div class="mt-4">
      <button id="darkToggleMobile" class="w-9 h-9 flex items-center justify-center rounded-full border border-stone-300 dark:border-stone-700 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors text-sm" aria-label="Toggle dark mode">
        <span id="darkIconMobile">☀️</span>
      </button>
    </div>
  </nav>
</div>
