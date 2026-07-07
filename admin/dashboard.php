<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Dashboard';

$total_products = $db->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
$total_orders = $db->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
$total_categories = $db->query("SELECT COUNT(*) as c FROM categories")->fetch_assoc()['c'];
$pending_orders = $db->query("SELECT COUNT(*) as c FROM orders WHERE status='pending'")->fetch_assoc()['c'];
$total_revenue = $db->query("SELECT COALESCE(SUM(total),0) as c FROM orders WHERE status!='cancelled'")->fetch_assoc()['c'];
$recent_orders = $db->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");

include __DIR__ . '/includes/header.php';
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
  <div class="bg-gradient-to-br from-stone-800 to-stone-900 border border-stone-700/50 rounded-2xl p-6 hover:border-stone-600 transition-all">
    <div class="flex items-center justify-between mb-4">
      <div class="w-11 h-11 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
      </div>
      <span class="text-xs font-medium text-blue-400 bg-blue-500/10 px-2.5 py-1 rounded-full">Produk</span>
    </div>
    <p class="text-3xl font-bold text-white"><?= $total_products ?></p>
    <p class="text-sm text-stone-400 mt-1">Total produk di database</p>
  </div>

  <div class="bg-gradient-to-br from-stone-800 to-stone-900 border border-stone-700/50 rounded-2xl p-6 hover:border-stone-600 transition-all">
    <div class="flex items-center justify-between mb-4">
      <div class="w-11 h-11 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
      </div>
      <span class="text-xs font-medium text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full"><?= $total_orders ?> total</span>
    </div>
    <p class="text-3xl font-bold text-white"><?= $total_orders ?></p>
    <p class="text-sm text-stone-400 mt-1">Total pesanan masuk</p>
  </div>

  <div class="bg-gradient-to-br from-stone-800 to-stone-900 border border-stone-700/50 rounded-2xl p-6 hover:border-stone-600 transition-all">
    <div class="flex items-center justify-between mb-4">
      <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <span class="text-xs font-medium text-amber-400 bg-amber-500/10 px-2.5 py-1 rounded-full">Pending</span>
    </div>
    <p class="text-3xl font-bold text-amber-400"><?= $pending_orders ?></p>
    <p class="text-sm text-stone-400 mt-1">Menunggu diproses</p>
  </div>

  <div class="bg-gradient-to-br from-stone-800 to-stone-900 border border-stone-700/50 rounded-2xl p-6 hover:border-stone-600 transition-all">
    <div class="flex items-center justify-between mb-4">
      <div class="w-11 h-11 rounded-xl bg-signature/10 border border-signature/20 flex items-center justify-center text-signature-light">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <span class="text-xs font-medium text-signature-light bg-signature/10 px-2.5 py-1 rounded-full">Revenue</span>
    </div>
    <p class="text-3xl font-bold text-white"><?= rupiah($total_revenue) ?></p>
    <p class="text-sm text-stone-400 mt-1">Total pendapatan</p>
  </div>
</div>

<!-- Recent Orders + Quick Links -->
<div class="grid lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5 border-b border-stone-800">
      <div>
        <h3 class="font-semibold text-white">Pesanan Terbaru</h3>
        <p class="text-xs text-stone-500 mt-0.5">5 pesanan terakhir</p>
      </div>
      <a href="<?= SITE_URL ?>/admin/orders.php" class="text-xs font-medium text-signature-light hover:text-white transition-colors">Lihat Semua →</a>
    </div>
    <?php if ($recent_orders->num_rows === 0): ?>
      <p class="text-stone-500 text-sm py-12 text-center">Belum ada pesanan.</p>
    <?php else: ?>
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="bg-stone-800/50">
            <th class="text-left px-6 py-3 text-xs font-medium text-stone-400 uppercase tracking-wider">ID</th>
            <th class="text-left px-6 py-3 text-xs font-medium text-stone-400 uppercase tracking-wider">Customer</th>
            <th class="text-left px-6 py-3 text-xs font-medium text-stone-400 uppercase tracking-wider">Total</th>
            <th class="text-left px-6 py-3 text-xs font-medium text-stone-400 uppercase tracking-wider">Status</th>
            <th class="text-right px-6 py-3 text-xs font-medium text-stone-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($o = $recent_orders->fetch_assoc()): ?>
          <tr class="border-t border-stone-800/50 hover:bg-stone-800/30 transition-colors">
            <td class="px-6 py-4">
              <span class="font-mono text-sm text-stone-300">#<?= $o['id'] ?></span>
            </td>
            <td class="px-6 py-4">
              <div>
                <p class="text-sm font-medium text-stone-200"><?= htmlspecialchars($o['customer_name']) ?></p>
                <p class="text-xs text-stone-500"><?= htmlspecialchars($o['email']) ?></p>
              </div>
            </td>
            <td class="px-6 py-4 text-sm font-medium text-stone-200"><?= rupiah($o['total']) ?></td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full
                <?= match($o['status']) {
                  'pending' => 'bg-amber-500/10 text-amber-400 border border-amber-500/20',
                  'confirmed' => 'bg-blue-500/10 text-blue-400 border border-blue-500/20',
                  'shipped' => 'bg-purple-500/10 text-purple-400 border border-purple-500/20',
                  'completed' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
                  'cancelled' => 'bg-red-500/10 text-red-400 border border-red-500/20',
                  default => 'bg-stone-800 text-stone-400 border border-stone-700',
                } ?>">
                <span class="w-1.5 h-1.5 rounded-full
                  <?= match($o['status']) {
                    'pending' => 'bg-amber-400',
                    'confirmed' => 'bg-blue-400',
                    'shipped' => 'bg-purple-400',
                    'completed' => 'bg-emerald-400',
                    'cancelled' => 'bg-red-400',
                    default => 'bg-stone-400',
                  } ?>">
                </span>
                <?= $o['status'] ?>
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <a href="<?= SITE_URL ?>/admin/order-detail.php?id=<?= $o['id'] ?>" class="text-xs font-medium text-stone-400 hover:text-white transition-colors">Detail</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

  <!-- Quick Actions -->
  <div class="space-y-5">
    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
      <h3 class="font-semibold text-white mb-4">Aksi Cepat</h3>
      <div class="space-y-3">
        <a href="<?= SITE_URL ?>/admin/product-add.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-stone-800/50 hover:bg-stone-800 border border-stone-700/50 hover:border-stone-600 transition-all group">
          <div class="w-9 h-9 rounded-lg bg-signature/10 flex items-center justify-center text-signature-light group-hover:bg-signature/20 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          </div>
          <div>
            <p class="text-sm font-medium text-stone-200">Tambah Produk</p>
            <p class="text-xs text-stone-500">Produk baru</p>
          </div>
        </a>
        <a href="<?= SITE_URL ?>/admin/orders.php?status=pending" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-stone-800/50 hover:bg-stone-800 border border-stone-700/50 hover:border-stone-600 transition-all group">
          <div class="w-9 h-9 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-400 group-hover:bg-amber-500/20 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div>
            <p class="text-sm font-medium text-stone-200">Pesanan Pending</p>
            <p class="text-xs text-stone-500"><?= $pending_orders ?> menunggu</p>
          </div>
        </a>
        <a href="<?= SITE_URL ?>/admin/blog-add.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-stone-800/50 hover:bg-stone-800 border border-stone-700/50 hover:border-stone-600 transition-all group">
          <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500/20 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          </div>
          <div>
            <p class="text-sm font-medium text-stone-200">Tulis Blog</p>
            <p class="text-xs text-stone-500">Artikel baru</p>
          </div>
        </a>
      </div>
    </div>

    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
      <h3 class="font-semibold text-white mb-4">Ringkasan</h3>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <span class="text-sm text-stone-400">Kategori</span>
          <span class="text-sm font-medium text-white"><?= $total_categories ?></span>
        </div>
        <div class="flex items-center justify-between pt-3 border-t border-stone-800">
          <span class="text-sm text-stone-400">Pending</span>
          <span class="text-sm font-medium text-amber-400"><?= $pending_orders ?></span>
        </div>
        <div class="flex items-center justify-between pt-3 border-t border-stone-800">
          <span class="text-sm text-stone-400">Revenue</span>
          <span class="text-sm font-medium text-emerald-400"><?= rupiah($total_revenue) ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
