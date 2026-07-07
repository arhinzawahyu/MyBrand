<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Dashboard';

$stats = [
  'products' => $db->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'],
  'orders' => $db->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'],
  'pending' => $db->query("SELECT COUNT(*) as c FROM orders WHERE status='pending'")->fetch_assoc()['c'],
  'revenue' => $db->query("SELECT COALESCE(SUM(total),0) as c FROM orders WHERE status!='cancelled'")->fetch_assoc()['c'],
  'categories' => $db->query("SELECT COUNT(*) as c FROM categories")->fetch_assoc()['c'],
  'messages' => $db->query("SELECT COUNT(*) as c FROM contacts")->fetch_assoc()['c'],
];
$recent_orders = $db->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");

include __DIR__ . '/includes/header.php';
?>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <div class="card p-5 border-l-4 border-l-blue-500">
    <p class="text-xs font-medium text-stone-500 uppercase tracking-wider">Products</p>
    <p class="text-2xl font-bold text-stone-800 mt-1"><?= $stats['products'] ?></p>
  </div>
  <div class="card p-5 border-l-4 border-l-emerald-500">
    <p class="text-xs font-medium text-stone-500 uppercase tracking-wider">Orders</p>
    <p class="text-2xl font-bold text-stone-800 mt-1"><?= $stats['orders'] ?></p>
  </div>
  <div class="card p-5 border-l-4 border-l-amber-500">
    <p class="text-xs font-medium text-stone-500 uppercase tracking-wider">Pending</p>
    <p class="text-2xl font-bold text-amber-600 mt-1"><?= $stats['pending'] ?></p>
  </div>
  <div class="card p-5 border-l-4 border-l-signature">
    <p class="text-xs font-medium text-stone-500 uppercase tracking-wider">Revenue</p>
    <p class="text-2xl font-bold text-stone-800 mt-1"><?= rupiah($stats['revenue']) ?></p>
  </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 card overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
      <div>
        <h3 class="font-semibold text-stone-800">Pesanan Terbaru</h3>
        <p class="text-xs text-stone-400 mt-0.5">5 pesanan terakhir</p>
      </div>
      <a href="<?= SITE_URL ?>/admin/orders.php" class="text-xs font-medium text-signature hover:text-signature-dark">Lihat Semua →</a>
    </div>
    <?php if ($recent_orders->num_rows === 0): ?>
      <p class="text-stone-400 text-sm py-12 text-center">Belum ada pesanan.</p>
    <?php else: ?>
    <div class="overflow-x-auto">
      <table class="w-full min-w-[500px]">
        <thead>
          <tr class="bg-stone-50">
            <th class="table-header">ID</th>
            <th class="table-header">Customer</th>
            <th class="table-header">Total</th>
            <th class="table-header">Status</th>
            <th class="table-header text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($o = $recent_orders->fetch_assoc()): ?>
          <tr class="border-t border-stone-100 hover:bg-stone-50/50 transition-colors">
            <td class="table-cell font-mono text-xs text-stone-400">#<?= $o['id'] ?></td>
            <td class="table-cell">
              <p class="font-medium text-stone-800"><?= htmlspecialchars($o['customer_name']) ?></p>
              <p class="text-xs text-stone-400"><?= htmlspecialchars($o['email']) ?></p>
            </td>
            <td class="table-cell font-medium"><?= rupiah($o['total']) ?></td>
            <td class="table-cell"><?= statusBadge($o['status']) ?></td>
            <td class="table-cell text-right">
              <a href="<?= SITE_URL ?>/admin/order-detail.php?id=<?= $o['id'] ?>" class="text-xs font-medium text-signature hover:text-signature-dark">Detail</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

  <div class="space-y-4">
    <div class="card p-5">
      <h3 class="font-semibold text-stone-800 mb-4">Aksi Cepat</h3>
      <div class="space-y-2">
        <a href="<?= SITE_URL ?>/admin/product-add.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-stone-50 hover:bg-stone-100 border border-stone-200 transition-all group">
          <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></div>
          <div><p class="text-sm font-medium text-stone-700">Tambah Produk</p><p class="text-xs text-stone-400">Produk baru</p></div>
        </a>
        <a href="<?= SITE_URL ?>/admin/orders.php?status=pending" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-stone-50 hover:bg-stone-100 border border-stone-200 transition-all group">
          <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
          <div><p class="text-sm font-medium text-stone-700">Pesanan Pending</p><p class="text-xs text-stone-400"><?= $stats['pending'] ?> menunggu</p></div>
        </a>
        <a href="<?= SITE_URL ?>/admin/blog-add.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-stone-50 hover:bg-stone-100 border border-stone-200 transition-all group">
          <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></div>
          <div><p class="text-sm font-medium text-stone-700">Tulis Blog</p><p class="text-xs text-stone-400">Artikel baru</p></div>
        </a>
      </div>
    </div>

    <div class="card p-5">
      <h3 class="font-semibold text-stone-800 mb-4">Ringkasan</h3>
      <div class="space-y-3">
        <div class="flex justify-between"><span class="text-sm text-stone-500">Kategori</span><span class="text-sm font-medium text-stone-800"><?= $stats['categories'] ?></span></div>
        <div class="flex justify-between pt-2 border-t border-stone-100"><span class="text-sm text-stone-500">Pending</span><span class="text-sm font-medium text-amber-600"><?= $stats['pending'] ?></span></div>
        <div class="flex justify-between pt-2 border-t border-stone-100"><span class="text-sm text-stone-500">Messages</span><span class="text-sm font-medium text-stone-800"><?= $stats['messages'] ?></span></div>
        <div class="flex justify-between pt-2 border-t border-stone-100"><span class="text-sm text-stone-500">Revenue</span><span class="text-sm font-medium text-emerald-600"><?= rupiah($stats['revenue']) ?></span></div>
      </div>
    </div>
  </div>
</div>

<?php
function statusBadge($status) {
  $map = [
    'pending' => ['bg-amber-50 text-amber-700 border-amber-200', 'bg-amber-500'],
    'confirmed' => ['bg-blue-50 text-blue-700 border-blue-200', 'bg-blue-500'],
    'shipped' => ['bg-purple-50 text-purple-700 border-purple-200', 'bg-purple-500'],
    'completed' => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'bg-emerald-500'],
    'cancelled' => ['bg-red-50 text-red-700 border-red-200', 'bg-red-500'],
  ];
  $c = $map[$status] ?? ['bg-stone-100 text-stone-600', 'bg-stone-400'];
  return "<span class=\"badge border {$c[0]}\"><span class=\"w-1.5 h-1.5 rounded-full {$c[1]}\"></span>{$status}</span>";
}
include __DIR__ . '/includes/footer.php';
?>
