<?php
require_once __DIR__ . '/../includes/functions.php';
$db = getDB();
$orders = $db->query("SELECT * FROM orders ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);

// Simple auth guard
$auth = $_SERVER['PHP_AUTH_USER'] ?? '';
$pass = $_SERVER['PHP_AUTH_PW'] ?? '';
if ($auth !== 'admin' || $pass !== 'langgarboy123') {
  header('WWW-Authenticate: Basic realm="LanggarBoy Admin"');
  header('HTTP/1.0 401 Unauthorized');
  echo 'Unauthorized';
  exit;
}

$title = 'Admin — LanggarBoy';
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — LanggarBoy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background: #0c0a09; color: #f5f5f4; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-thumb { background: #44403c; border-radius: 3px; }
  </style>
</head>
<body class="p-8">
  <div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-10">
      <h1 class="text-2xl font-bold">LANGGAR<span class="text-red-600">BOY</span> Admin</h1>
      <a href="/MyBrand/" class="text-sm text-stone-400 hover:text-white">Lihat Situs &rarr;</a>
    </div>

    <div class="mb-8">
      <h2 class="text-lg font-semibold mb-4">Pesanan Masuk</h2>
      <?php if (empty($orders)): ?>
        <p class="text-stone-500">Belum ada pesanan.</p>
      <?php else: ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border border-stone-800">
          <thead class="bg-stone-900">
            <tr>
              <th class="px-4 py-3 border-b border-stone-800">ID</th>
              <th class="px-4 py-3 border-b border-stone-800">Nama</th>
              <th class="px-4 py-3 border-b border-stone-800">Email</th>
              <th class="px-4 py-3 border-b border-stone-800">Total</th>
              <th class="px-4 py-3 border-b border-stone-800">Status</th>
              <th class="px-4 py-3 border-b border-stone-800">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $o): ?>
            <tr class="border-b border-stone-800 hover:bg-stone-900/50">
              <td class="px-4 py-3">#<?= $o['id'] ?></td>
              <td class="px-4 py-3"><?= htmlspecialchars($o['customer_name']) ?></td>
              <td class="px-4 py-3"><?= htmlspecialchars($o['email']) ?></td>
              <td class="px-4 py-3"><?= rupiah($o['total']) ?></td>
              <td class="px-4 py-3">
                <span class="text-xs px-2 py-1 rounded <?= $o['status'] === 'pending' ? 'bg-yellow-900 text-yellow-200' : 'bg-green-900 text-green-200' ?>">
                  <?= $o['status'] ?>
                </span>
              </td>
              <td class="px-4 py-3 text-stone-400"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <div>
      <h2 class="text-lg font-semibold mb-4">Database Status</h2>
      <div class="grid grid-cols-4 gap-4">
        <?php
        $tables = ['products', 'categories', 'orders', 'blog_posts'];
        foreach ($tables as $t):
          $count = $db->query("SELECT COUNT(*) as c FROM $t")->fetch_assoc()['c'];
        ?>
        <div class="bg-stone-900 rounded p-4">
          <p class="text-xs uppercase tracking-wider text-stone-400"><?= $t ?></p>
          <p class="text-2xl font-bold mt-1"><?= $count ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</body>
</html>
