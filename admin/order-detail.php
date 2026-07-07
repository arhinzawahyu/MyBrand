<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Detail Pesanan';

$id = $_GET['id'] ?? 0;
$order = $db->query("SELECT * FROM orders WHERE id=$id")->fetch_assoc();
if (!$order) redirect(SITE_URL . '/admin/orders.php');

$items = $db->query("SELECT oi.*,p.slug FROM order_items oi LEFT JOIN products p ON oi.product_id=p.id WHERE oi.order_id=$id");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
  $db->query("UPDATE orders SET status='{$_POST['status']}' WHERE id=$id");
  $_SESSION['flash'] = 'Status diupdate.'; redirect(SITE_URL . "/admin/order-detail.php?id=$id");
}

$statusColors = [
  'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
  'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
  'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
  'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
  'cancelled' => 'bg-red-50 text-red-700 border-red-200',
];

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto space-y-6">
  <a href="<?= SITE_URL ?>/admin/orders.php" class="text-sm text-stone-500 hover:text-stone-700 flex items-center gap-1">&larr; Kembali</a>

  <div class="card p-5 space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <h3 class="font-semibold text-stone-800">Pesanan #<?= $order['id'] ?></h3>
      <span class="badge border <?= $statusColors[$order['status']] ?> self-start"><?= $order['status'] ?></span>
    </div>
    <div class="grid sm:grid-cols-2 gap-4 text-sm">
      <div><span class="text-stone-400">Nama</span><p class="font-medium text-stone-800"><?= htmlspecialchars($order['customer_name']) ?></p></div>
      <div><span class="text-stone-400">Email</span><p class="font-medium text-stone-800"><?= htmlspecialchars($order['email']) ?></p></div>
      <div><span class="text-stone-400">No. HP</span><p class="font-medium text-stone-800"><?= htmlspecialchars($order['phone'] ?: '-') ?></p></div>
      <div><span class="text-stone-400">Tanggal</span><p class="font-medium text-stone-800"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p></div>
      <div class="sm:col-span-2"><span class="text-stone-400">Alamat</span><p class="font-medium text-stone-800"><?= nl2br(htmlspecialchars($order['address'] ?: '-')) ?></p></div>
      <?php if ($order['notes']): ?>
      <div class="sm:col-span-2"><span class="text-stone-400">Catatan</span><p class="text-stone-600"><?= nl2br(htmlspecialchars($order['notes'])) ?></p></div>
      <?php endif; ?>
    </div>
  </div>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full min-w-[400px]">
        <thead><tr class="bg-stone-50 border-b border-stone-200"><th class="table-header">Produk</th><th class="table-header">Size</th><th class="table-header">Warna</th><th class="table-header">Qty</th><th class="table-header text-right">Subtotal</th></tr></thead>
        <tbody>
          <?php while ($item = $items->fetch_assoc()): ?>
          <tr class="border-t border-stone-100">
            <td class="table-cell font-medium text-stone-800"><?= htmlspecialchars($item['product_name']) ?></td>
            <td class="table-cell text-stone-500"><?= $item['size'] ?: '-' ?></td>
            <td class="table-cell text-stone-500"><?= $item['color'] ?: '-' ?></td>
            <td class="table-cell"><?= $item['quantity'] ?></td>
            <td class="table-cell text-right font-medium"><?= rupiah($item['price'] * $item['quantity']) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
        <tfoot><tr class="border-t border-stone-200 bg-stone-50"><td colspan="4" class="table-cell text-right font-semibold text-stone-700">Total</td><td class="table-cell text-right font-bold text-stone-800 text-lg"><?= rupiah($order['total']) ?></td></tr></tfoot>
      </table>
    </div>
  </div>

  <div class="card p-5">
    <h3 class="font-semibold text-stone-800 mb-4">Update Status</h3>
    <form method="POST" class="flex flex-wrap gap-2">
      <?php foreach (['pending','confirmed','shipped','completed','cancelled'] as $s): ?>
      <button type="submit" name="status" value="<?= $s ?>" class="btn <?= $s===$order['status'] ? 'btn-primary' : 'btn-secondary' ?> text-xs" <?= $s===$order['status']?'disabled':'' ?>><?= ucfirst($s) ?></button>
      <?php endforeach; ?>
    </form>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
