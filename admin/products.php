<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Products';
$products = $db->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id=c.id ORDER BY p.created_at DESC");
include __DIR__ . '/includes/header.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
  <div>
    <h3 class="text-lg font-semibold text-stone-800">Semua Produk</h3>
    <p class="text-sm text-stone-400"><?= $products->num_rows ?> produk</p>
  </div>
  <a href="<?= SITE_URL ?>/admin/product-add.php" class="btn btn-primary">+ Tambah Produk</a>
</div>

<div class="card overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full min-w-[600px]">
      <thead>
        <tr class="bg-stone-50 border-b border-stone-200">
          <th class="table-header">Produk</th>
          <th class="table-header hidden sm:table-cell">Kategori</th>
          <th class="table-header">Harga</th>
          <th class="table-header hidden md:table-cell">Label</th>
          <th class="table-header text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($p = $products->fetch_assoc()):
          $img = $db->query("SELECT url FROM product_images WHERE product_id={$p['id']} ORDER BY sort_order LIMIT 1")->fetch_assoc();
          $discount = $p['original_price'] ? round((($p['original_price']-$p['price'])/$p['original_price'])*100) : 0;
        ?>
        <tr class="border-t border-stone-100 hover:bg-stone-50/50">
          <td class="table-cell">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-stone-100 bg-cover bg-center shrink-0" style="background-image:url('<?= $img['url'] ?? '' ?>')"></div>
              <span class="font-medium text-stone-800"><?= htmlspecialchars($p['name']) ?></span>
            </div>
          </td>
          <td class="table-cell hidden sm:table-cell text-stone-500"><?= $p['category_name'] ?></td>
          <td class="table-cell font-medium"><?= rupiah($p['price']) ?></td>
          <td class="table-cell hidden md:table-cell">
            <div class="flex gap-1 flex-wrap">
              <?php if ($p['is_new']): ?><span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded font-medium">New</span><?php endif; ?>
              <?php if ($discount): ?><span class="text-[10px] bg-signature/10 text-signature px-1.5 py-0.5 rounded font-medium">-<?= $discount ?>%</span><?php endif; ?>
              <?php if ($p['is_pre_order']): ?><span class="text-[10px] bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded font-medium">PO</span><?php endif; ?>
            </div>
          </td>
          <td class="table-cell text-right whitespace-nowrap">
            <a href="<?= SITE_URL ?>/admin/product-edit.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs py-1.5">Edit</a>
            <a href="<?= SITE_URL ?>/admin/product-delete.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs py-1.5 text-red-500 hover:text-red-700 hover:bg-red-50" onclick="return confirm('Hapus produk ini?')">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
        <?php if ($products->num_rows === 0): ?>
        <tr><td colspan="5" class="text-center text-stone-400 py-10 text-sm">Belum ada produk.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
