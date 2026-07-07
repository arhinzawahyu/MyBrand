<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Products';
$products = $db->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");

include __DIR__ . '/includes/header.php';
?>

<div class="flex items-center justify-between mb-6">
  <p class="text-sm text-stone-400"><?= $products->num_rows ?> produk</p>
  <a href="<?= SITE_URL ?>/admin/product-add.php" class="btn btn-primary">+ Tambah Produk</a>
</div>

<div class="card p-0 overflow-hidden">
  <table class="w-full">
    <thead>
      <tr class="border-b border-stone-800 bg-stone-900/50">
        <th class="table-header">Produk</th>
        <th class="table-header hidden md:table-cell">Kategori</th>
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
      <tr class="border-b border-stone-800/50 hover:bg-stone-800/30">
        <td class="table-cell">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-stone-800 bg-cover bg-center shrink-0" style="background-image:url('<?= $img['url'] ?? '' ?>')"></div>
            <span class="font-medium"><?= htmlspecialchars($p['name']) ?></span>
          </div>
        </td>
        <td class="table-cell hidden md:table-cell text-stone-400"><?= $p['category_name'] ?></td>
        <td class="table-cell"><?= rupiah($p['price']) ?></td>
        <td class="table-cell hidden md:table-cell">
          <div class="flex gap-1">
            <?php if ($p['is_new']): ?><span class="text-[10px] bg-stone-700 text-stone-300 px-1.5 py-0.5 rounded">New</span><?php endif; ?>
            <?php if ($discount): ?><span class="text-[10px] bg-signature text-white px-1.5 py-0.5 rounded">-<?= $discount ?>%</span><?php endif; ?>
            <?php if ($p['is_pre_order']): ?><span class="text-[10px] bg-stone-700 text-stone-300 px-1.5 py-0.5 rounded">PO</span><?php endif; ?>
          </div>
        </td>
        <td class="table-cell text-right">
          <a href="<?= SITE_URL ?>/admin/product-edit.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs">Edit</a>
          <a href="<?= SITE_URL ?>/admin/product-delete.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs text-red-400 hover:text-red-300" onclick="return confirm('Hapus produk ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
