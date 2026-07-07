<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Orders';

$status_filter = $_GET['status'] ?? '';
$sql = "SELECT * FROM orders";
if ($status_filter) $sql .= " WHERE status='$status_filter'";
$sql .= " ORDER BY created_at DESC";
$orders = $db->query($sql);

include __DIR__ . '/includes/header.php';
?>

<div class="flex items-center gap-3 mb-6 flex-wrap">
  <a href="<?= SITE_URL ?>/admin/orders.php" class="btn <?= !$status_filter ? 'btn-primary' : 'btn-ghost' ?> text-xs">Semua</a>
  <a href="<?= SITE_URL ?>/admin/orders.php?status=pending" class="btn <?= $status_filter === 'pending' ? 'btn-primary' : 'btn-ghost' ?> text-xs">Pending</a>
  <a href="<?= SITE_URL ?>/admin/orders.php?status=confirmed" class="btn <?= $status_filter === 'confirmed' ? 'btn-primary' : 'btn-ghost' ?> text-xs">Confirmed</a>
  <a href="<?= SITE_URL ?>/admin/orders.php?status=shipped" class="btn <?= $status_filter === 'shipped' ? 'btn-primary' : 'btn-ghost' ?> text-xs">Shipped</a>
  <a href="<?= SITE_URL ?>/admin/orders.php?status=completed" class="btn <?= $status_filter === 'completed' ? 'btn-primary' : 'btn-ghost' ?> text-xs">Completed</a>
  <a href="<?= SITE_URL ?>/admin/orders.php?status=cancelled" class="btn <?= $status_filter === 'cancelled' ? 'btn-primary' : 'btn-ghost' ?> text-xs">Cancelled</a>
</div>

<div class="card p-0 overflow-hidden">
  <table class="w-full">
    <thead>
      <tr class="border-b border-stone-800 bg-stone-900/50">
        <th class="table-header">ID</th>
        <th class="table-header">Customer</th>
        <th class="table-header hidden md:table-cell">Email</th>
        <th class="table-header">Total</th>
        <th class="table-header">Status</th>
        <th class="table-header hidden md:table-cell">Tanggal</th>
        <th class="table-header text-right">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($orders->num_rows === 0): ?>
      <tr><td colspan="7" class="table-cell text-center text-stone-500 py-10">Belum ada pesanan.</td></tr>
      <?php endif; ?>
      <?php while ($o = $orders->fetch_assoc()): ?>
      <tr class="border-b border-stone-800/50 hover:bg-stone-800/30">
        <td class="table-cell font-mono">#<?= $o['id'] ?></td>
        <td class="table-cell font-medium"><?= htmlspecialchars($o['customer_name']) ?></td>
        <td class="table-cell hidden md:table-cell text-stone-400"><?= htmlspecialchars($o['email']) ?></td>
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
        <td class="table-cell hidden md:table-cell text-stone-400"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
        <td class="table-cell text-right">
          <a href="<?= SITE_URL ?>/admin/order-detail.php?id=<?= $o['id'] ?>" class="btn btn-ghost text-xs">Detail</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
