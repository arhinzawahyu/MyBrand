<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Admin' ?> — LanggarBoy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .btn { @apply px-4 py-2 text-sm font-medium rounded-lg transition-colors inline-flex items-center gap-2; }
    .btn-primary { @apply bg-signature text-white hover:bg-signature-dark; }
    .btn-ghost { @apply text-stone-400 hover:text-white hover:bg-stone-800; }
    .btn-danger { @apply bg-red-600 text-white hover:bg-red-700; }
    .card { @apply bg-stone-900 border border-stone-800 rounded-xl p-6; }
    .input { @apply w-full bg-stone-800/50 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100 placeholder-stone-500 focus:outline-none focus:border-signature transition-colors; }
    .select { @apply w-full bg-stone-800/50 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100 focus:outline-none focus:border-signature transition-colors; }
    .textarea { @apply w-full bg-stone-800/50 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100 placeholder-stone-500 focus:outline-none focus:border-signature transition-colors resize-vertical; }
    .label { @apply block text-sm font-medium text-stone-300 mb-1.5; }
    .table-header { @apply px-4 py-3 text-left text-xs font-medium text-stone-400 uppercase tracking-wider; }
    .table-cell { @apply px-4 py-3 text-sm text-stone-300; }
  </style>
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen flex">
  <?php require_once __DIR__ . '/sidebar.php'; ?>
  <div class="flex-1 flex flex-col min-h-screen">
    <header class="h-16 border-b border-stone-800 flex items-center justify-between px-6 bg-stone-950 sticky top-0 z-10">
      <div class="flex items-center gap-3">
        <div class="w-2 h-2 rounded-full bg-emerald-400/80 animate-pulse"></div>
        <h2 class="text-base font-semibold text-stone-200"><?= $title ?? 'Dashboard' ?></h2>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-7 h-7 rounded-full bg-signature/20 flex items-center justify-center text-signature-light text-xs font-bold"><?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?></div>
        <span class="text-sm text-stone-400"><?= $_SESSION['admin_name'] ?? 'Admin' ?></span>
      </div>
    </header>
    <main class="flex-1 p-6">
