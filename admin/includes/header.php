<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Admin' ?> — LanggarBoy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            signature: { DEFAULT: '#A31F34', light: '#D94A5E', dark: '#7A1425' },
          },
          fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
        }
      }
    }
  </script>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #f5f5f4; color: #1c1917; }
    .btn { @apply inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200; }
    .btn-primary { @apply bg-signature text-white hover:bg-signature-dark shadow-sm hover:shadow-md; }
    .btn-secondary { @apply bg-stone-100 text-stone-700 hover:bg-stone-200 border border-stone-200; }
    .btn-ghost { @apply text-stone-500 hover:text-stone-700 hover:bg-stone-100; }
    .btn-danger { @apply bg-red-600 text-white hover:bg-red-700; }
    .card { @apply bg-white border border-stone-200 rounded-xl shadow-sm; }
    .input { @apply w-full border border-stone-300 rounded-lg px-4 py-2.5 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-signature focus:ring-1 focus:ring-signature/20 transition-all bg-white; }
    .select { @apply w-full border border-stone-300 rounded-lg px-4 py-2.5 text-sm text-stone-700 focus:outline-none focus:border-signature focus:ring-1 focus:ring-signature/20 transition-all bg-white; }
    .textarea { @apply w-full border border-stone-300 rounded-lg px-4 py-2.5 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-signature focus:ring-1 focus:ring-signature/20 transition-all resize-vertical bg-white; }
    .label { @apply block text-sm font-medium text-stone-700 mb-1.5; }
    .table-header { @apply px-4 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider bg-stone-50; }
    .table-cell { @apply px-4 py-3.5 text-sm text-stone-700; }
    .badge { @apply inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full; }
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-thumb { background: #d6d3d1; border-radius: 10px; }
    ::-webkit-scrollbar-track { background: transparent; }
  </style>
</head>
<body>
  <?php require_once __DIR__ . '/sidebar.php'; ?>
  <div id="mainContent" class="flex-1 flex flex-col min-h-screen lg:ml-64">
    <header class="h-16 bg-white border-b border-stone-200 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-20">
      <div class="flex items-center gap-3">
        <button id="sidebarToggle" class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-stone-100 text-stone-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
        <h2 class="text-base font-semibold text-stone-800"><?= $title ?? 'Dashboard' ?></h2>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-signature/10 flex items-center justify-center text-signature text-sm font-bold"><?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?></div>
        <span class="text-sm text-stone-600 hidden sm:block"><?= $_SESSION['admin_name'] ?? 'Admin' ?></span>
      </div>
    </header>

    <!-- Mobile overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/30 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <main class="flex-1 p-4 lg:p-6">
