<?php
$current = basename($_SERVER['PHP_SELF']);

$navItems = [
  'dashboard.php' => [
    'label' => 'Dashboard',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
    'match' => 'dashboard',
  ],
  'products.php' => [
    'label' => 'Products',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
    'match' => 'product',
  ],
  'categories.php' => [
    'label' => 'Categories',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>',
    'match' => 'categor',
  ],
  'orders.php' => [
    'label' => 'Orders',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
    'match' => 'order',
  ],
  'blog.php' => [
    'label' => 'Blog',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>',
    'match' => 'blog',
  ],
  'contacts.php' => [
    'label' => 'Messages',
    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
    'match' => 'contact',
  ],
];

function isActive($match) {
  global $current;
  return strpos($current, $match) !== false;
}
?>
<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-white border-r border-stone-200 shadow-sm -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
  <div class="h-16 flex items-center justify-between px-5 border-b border-stone-200">
    <a href="<?= SITE_URL ?>/admin/dashboard.php" class="flex items-center gap-3">
      <div class="w-8 h-8 rounded-lg bg-signature flex items-center justify-center text-white text-xs font-bold">LB</div>
      <div>
        <p class="text-sm font-bold text-stone-800 leading-none">LanggarBoy</p>
        <p class="text-[10px] text-stone-400 uppercase tracking-wider mt-0.5">Admin Panel</p>
      </div>
    </a>
    <button id="closeSidebar" class="lg:hidden w-7 h-7 flex items-center justify-center rounded hover:bg-stone-100 text-stone-400">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
  </div>

  <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
    <?php foreach ($navItems as $file => $item):
      $active = isActive($item['match']);
    ?>
    <a href="<?= SITE_URL ?>/admin/<?= $file ?>"
      class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 group
        <?= $active
          ? 'bg-signature/10 text-signature font-medium'
          : 'text-stone-600 hover:text-stone-800 hover:bg-stone-100'
        ?>">
      <span class="shrink-0 <?= $active ? 'text-signature' : 'text-stone-400 group-hover:text-stone-600' ?>">
        <?= $item['icon'] ?>
      </span>
      <span class="text-sm"><?= $item['label'] ?></span>
      <?php if ($active): ?>
      <span class="ml-auto w-1.5 h-1.5 rounded-full bg-signature"></span>
      <?php endif; ?>
    </a>
    <?php endforeach; ?>
  </nav>

  <div class="p-3 border-t border-stone-200 space-y-0.5">
    <a href="<?= SITE_URL ?>/" target="_blank"
      class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-stone-500 hover:text-stone-700 hover:bg-stone-100 transition-all text-sm">
      <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
      View Site
    </a>
    <a href="<?= SITE_URL ?>/admin/logout.php"
      class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-stone-500 hover:text-red-600 hover:bg-red-50 transition-all text-sm">
      <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
      Logout
    </a>
  </div>
</aside>

<script>
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const isOpen = !sidebar.classList.contains('-translate-x-full');
  sidebar.classList.toggle('-translate-x-full', !isOpen);
  if (overlay) overlay.classList.toggle('hidden', isOpen);
}
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('sidebarToggle');
  const close = document.getElementById('closeSidebar');
  if (toggle) toggle.addEventListener('click', toggleSidebar);
  if (close) close.addEventListener('click', toggleSidebar);
});
</script>
