<?php
$current = basename($_SERVER['PHP_SELF']);
?>
<aside class="w-64 bg-stone-900/50 border-r border-stone-800 min-h-screen flex flex-col shrink-0">
  <div class="h-16 flex items-center px-6 border-b border-stone-800">
    <a href="<?= SITE_URL ?>/admin/dashboard.php" class="text-lg font-bold tracking-tight text-white">
      LANGGAR<span class="text-signature">BOY</span>
      <span class="block text-[10px] uppercase tracking-[0.2em] text-stone-500 font-normal">Admin Panel</span>
    </a>
  </div>
  <nav class="flex-1 p-4 space-y-1">
    <a href="<?= SITE_URL ?>/admin/dashboard.php" class="sidebar-link <?= $current === 'dashboard.php' ? 'active' : '' ?>">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      Dashboard
    </a>
    <a href="<?= SITE_URL ?>/admin/products.php" class="sidebar-link <?= strpos($current, 'product') !== false ? 'active' : '' ?>">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
      Products
    </a>
    <a href="<?= SITE_URL ?>/admin/categories.php" class="sidebar-link <?= strpos($current, 'categor') !== false ? 'active' : '' ?>">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
      Categories
    </a>
    <a href="<?= SITE_URL ?>/admin/orders.php" class="sidebar-link <?= strpos($current, 'order') !== false ? 'active' : '' ?>">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
      Orders
    </a>
    <a href="<?= SITE_URL ?>/admin/blog.php" class="sidebar-link <?= strpos($current, 'blog') !== false ? 'active' : '' ?>">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
      Blog
    </a>
    <a href="<?= SITE_URL ?>/admin/contacts.php" class="sidebar-link <?= strpos($current, 'contact') !== false ? 'active' : '' ?>">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
      Messages
    </a>
  </nav>
  <div class="p-4 border-t border-stone-800">
    <a href="<?= SITE_URL ?>/" target="_blank" class="sidebar-link text-xs">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
      View Site
    </a>
  </div>
</aside>
