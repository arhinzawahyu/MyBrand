<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Detail Pesanan';

$id = $_GET['id'] ?? 0;
$order = $db->query("SELECT * FROM orders WHERE id=$id")->fetch_assoc();
if (!$order) redirect(SITE_URL . '/admin/orders.php');

$items = $db->query("SELECT oi.*, p.slug FROM order_items oi LEFT JOIN products p ON oi.product_id=p.id WHERE oi.order_id=$id");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
  $stmt = $db->prepare("UPDATE orders SET status=? WHERE id=?");
  $stmt->bind_param('si', $_POST['status'], $id);
  $stmt->execute();
  $_SESSION['flash'] = 'Status pesanan diupdate.';
  redirect(SITE_URL . "/admin/order-detail.php?id=$id");
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-4xl space-y-6">
  <div class="card space-y-4">
    <div class="flex items-center justify-between">
      <h3 class="font-semibold">Pesanan #<?= $order['id'] ?></h3>
      <span class="text-xs px-3 py-1 rounded font-medium
        <?= match($order['status']) {
          'pending' => 'bg-yellow-900/50 text-yellow-300',
          'confirmed' => 'bg-blue-900/50 text-blue-300',
          'shipped' => 'bg-purple-900/50 text-purple-300',
          'completed' => 'bg-green-900/50 text-green-300',
          'cancelled' => 'bg-red-900/50 text-red-300',
          default => 'bg-stone-800 text-stone-400',
        } ?>">
        <?= $order['status'] ?>
      </span>
    </div>

    <div class="grid md:grid-cols-2 gap-4 text-sm">
      <div>
        <p class="text-stone-500">Nama</p>
        <p class="font-medium"><?= htmlspecialchars($order['customer_name']) ?></p>
      </div>
      <div>
        <p class="text-stone-500">Email</p>
        <p class="font-medium"><?= htmlspecialchars($order['email']) ?></p>
      </div>
      <div>
        <p class="text-stone-500">No. HP</p>
        <p class="font-medium"><?= htmlspecialchars($order['phone'] ?: '-') ?></p>
      </div>
      <div>
        <p class="text-stone-500">Tanggal</p>
        <p class="font-medium"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
      </div>
      <div class="md:col-span-2">
        <p class="text-stone-500">Alamat</p>
        <p class="font-medium"><?= nl2br(htmlspecialchars($order['address'] ?: '-')) ?></p>
      </div>
      <?php if ($order['notes']): ?>
      <div class="md:col-span-2">
        <p class="text-stone-500">Catatan</p>
        <p class="font-medium text-stone-400"><?= nl2br(htmlspecialchars($order['notes'])) ?></p>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="card p-0 overflow-hidden">
    <table class="w-full">
      <thead>
        <tr class="border-b border-stone-800 bg-stone-900/50">
          <th class="table-header">Produk</th>
          <th class="table-header">Size</th>
          <th class="table-header">Warna</th>
          <th class="table-header">Qty</th>
          <th class="table-header text-right">Harga</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($item = $items->fetch_assoc()): ?>
        <tr class="border-b border-stone-800/50">
          <td class="table-cell">
            <div class="flex items-center gap-2">
              <span class="font-medium"><?= htmlspecialchars($item['product_name']) ?></span>
            </div>
          </td>
          <td class="table-cell text-stone-400"><?= $item['size'] ?: '-' ?></td>
          <td class="table-cell text-stone-400"><?= $item['color'] ?: '-' ?></td>
          <td class="table-cell"><?= $item['quantity'] ?></td>
          <td class="table-cell text-right"><?= rupiah($item['price'] * $item['quantity']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
      <tfoot>
        <tr class="border-t border-stone-800">
          <td colspan="4" class="table-cell text-right font-semibold">Total</td>
          <td class="table-cell text-right font-semibold text-lg"><?= rupiah($order['total']) ?></td>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class="card">
    <h3 class="font-semibold mb-3">Update Status</h3>
    <form method="POST" class="flex gap-3 flex-wrap">
      <?php foreach (['pending','confirmed','shipped','completed','cancelled'] as $s): ?>
      <button type="submit" name="status" value="<?= $s ?>" class="btn <?= $s === $order['status'] ? 'btn-primary' : 'btn-ghost' ?> text-xs" <?= $s === $order['status'] ? 'disabled' : '' ?>>
        <?= ucfirst($s) ?>
      </button>
      <?php endforeach; ?>
    </form>
  </div>

  <a href="<?= SITE_URL ?>/admin/orders.php" class="btn btn-ghost">&larr; Kembali</a>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
