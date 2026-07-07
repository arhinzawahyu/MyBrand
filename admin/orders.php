<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Orders';

$status_filter = $_GET['status'] ?? '';
$orders = $db->query("SELECT * FROM orders" . ($status_filter ? " WHERE status='$status_filter'" : "") . " ORDER BY created_at DESC");

include __DIR__ . '/includes/header.php';
?>

<div class="flex flex-wrap items-center gap-2 mb-6">
  <a href="<?= SITE_URL ?>/admin/orders.php" class="btn <?= !$status_filter ? 'btn-primary' : 'btn-secondary' ?> text-xs">Semua</a>
  <?php foreach (['pending','confirmed','shipped','completed','cancelled'] as $s): ?>
  <a href="?status=<?= $s ?>" class="btn <?= $status_filter===$s ? 'btn-primary' : 'btn-secondary' ?> text-xs"><?= ucfirst($s) ?></a>
  <?php endforeach; ?>
</div>

<div class="card overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full min-w-[600px]">
      <thead><tr class="bg-stone-50 border-b border-stone-200"><th class="table-header">ID</th><th class="table-header">Customer</th><th class="table-header hidden md:table-cell">Email</th><th class="table-header">Total</th><th class="table-header">Status</th><th class="table-header hidden md:table-cell">Tanggal</th><th class="table-header text-right">Aksi</th></tr></thead>
      <tbody>
        <?php if ($orders->num_rows === 0): ?>
        <tr><td colspan="7" class="text-center text-stone-400 py-10 text-sm">Belum ada pesanan.</td></tr>
        <?php endif; ?>
        <?php while ($o = $orders->fetch_assoc()): ?>
        <tr class="border-t border-stone-100 hover:bg-stone-50/50">
          <td class="table-cell font-mono text-xs text-stone-400">#<?= $o['id'] ?></td>
          <td class="table-cell font-medium text-stone-800"><?= htmlspecialchars($o['customer_name']) ?></td>
          <td class="table-cell hidden md:table-cell text-stone-500"><?= htmlspecialchars($o['email']) ?></td>
          <td class="table-cell font-medium"><?= rupiah($o['total']) ?></td>
          <td class="table-cell">
            <span class="badge border <?= match($o['status']) {
              'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
              'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
              'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
              'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
              'cancelled' => 'bg-red-50 text-red-700 border-red-200',
              default => 'bg-stone-100 text-stone-600 border-stone-200',
            } ?>"><?= $o['status'] ?></span>
          </td>
          <td class="table-cell hidden md:table-cell text-stone-400 text-xs"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
          <td class="table-cell text-right"><a href="<?= SITE_URL ?>/admin/order-detail.php?id=<?= $o['id'] ?>" class="btn btn-ghost text-xs py-1">Detail</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
