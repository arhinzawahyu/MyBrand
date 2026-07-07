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
    .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 text-sm text-stone-400 hover:text-stone-100 hover:bg-stone-800/50 rounded-lg transition-colors; }
    .sidebar-link.active { @apply text-white bg-stone-800; }
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
      <h2 class="text-lg font-semibold"><?= $title ?? 'Dashboard' ?></h2>
      <div class="flex items-center gap-4">
        <span class="text-sm text-stone-400"><?= $_SESSION['admin_name'] ?? '' ?></span>
        <a href="<?= SITE_URL ?>/admin/logout.php" class="text-sm text-stone-500 hover:text-red-400 transition-colors">Logout</a>
      </div>
    </header>
    <main class="flex-1 p-6">
