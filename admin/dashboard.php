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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
  <div class="card">
    <p class="text-xs uppercase tracking-wider text-stone-500 mb-1">Total Produk</p>
    <p class="text-3xl font-bold"><?= $total_products ?></p>
  </div>
  <div class="card">
    <p class="text-xs uppercase tracking-wider text-stone-500 mb-1">Total Pesanan</p>
    <p class="text-3xl font-bold"><?= $total_orders ?></p>
  </div>
  <div class="card">
    <p class="text-xs uppercase tracking-wider text-stone-500 mb-1">Pending</p>
    <p class="text-3xl font-bold text-yellow-400"><?= $pending_orders ?></p>
  </div>
  <div class="card">
    <p class="text-xs uppercase tracking-wider text-stone-500 mb-1">Revenue</p>
    <p class="text-3xl font-bold"><?= rupiah($total_revenue) ?></p>
  </div>
</div>

<div class="card">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-semibold">Pesanan Terbaru</h3>
    <a href="<?= SITE_URL ?>/admin/orders.php" class="btn btn-ghost text-sm">Lihat Semua</a>
  </div>
  <?php if ($recent_orders->num_rows === 0): ?>
    <p class="text-stone-500 text-sm py-8 text-center">Belum ada pesanan.</p>
  <?php else: ?>
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead>
        <tr class="border-b border-stone-800">
          <th class="table-header">ID</th>
          <th class="table-header">Customer</th>
          <th class="table-header">Total</th>
          <th class="table-header">Status</th>
          <th class="table-header">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($o = $recent_orders->fetch_assoc()): ?>
        <tr class="border-b border-stone-800/50 hover:bg-stone-800/30">
          <td class="table-cell font-mono">#<?= $o['id'] ?></td>
          <td class="table-cell"><?= htmlspecialchars($o['customer_name']) ?></td>
          <td class="table-cell"><?= rupiah($o['total']) ?></td>
          <td class="table-cell">
            <span class="text-xs px-2 py-0.5 rounded font-medium
              <?= match($o['status']) {
                'pending' => 'bg-yellow-900/50 text-yellow-300',
                'confirmed' => 'bg-blue-900/50 text-blue-300',
                'shipped' => 'bg-purple-900/50 text-purple-300',
                'completed' => 'bg-green-900/50 text-green-300',
                'cancelled' => 'bg-red-900/50 text-red-300',
                default => 'bg-stone-800 text-stone-400',
              } ?>">
              <?= $o['status'] ?>
            </span>
          </td>
          <td class="table-cell text-stone-400"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
