<?php
require_once __DIR__ . '/includes/functions.php';
$title = 'Produk — LanggarBoy';
$db = getDB();
$category_slug = $_GET['cat'] ?? 'all';
$sort = $_GET['sort'] ?? 'terbaru';
$products = getProducts($category_slug, $sort);
$categories = getCategories();
include __DIR__ . '/includes/header.php';
?>

<div class="pt-28 pb-20">
  <div class="max-w-7xl mx-auto px-6">
    <div class="reveal">
      <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-2">Koleksi</p>
      <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-10">Produk</h1>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 pb-6 border-b border-stone-200 dark:border-stone-800">
      <div class="flex gap-1 flex-wrap" id="filterButtons">
        <a href="?cat=all&sort=<?= $sort ?>" class="px-4 py-2 text-xs uppercase tracking-[0.15em] transition-colors <?= $category_slug === 'all' ? 'bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900' : 'text-stone-500 hover:text-stone-900 dark:hover:text-stone-100' ?>">Semua</a>
        <?php foreach ($categories as $cat): ?>
        <a href="?cat=<?= $cat['slug'] ?>&sort=<?= $sort ?>" class="px-4 py-2 text-xs uppercase tracking-[0.15em] transition-colors <?= $category_slug === $cat['slug'] ? 'bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900' : 'text-stone-500 hover:text-stone-900 dark:hover:text-stone-100' ?>"><?= $cat['name'] ?></a>
        <?php endforeach; ?>
      </div>

      <select id="sortSelect" onchange="window.location='?cat=<?= $category_slug ?>&sort='+this.value" class="text-xs uppercase tracking-[0.15em] bg-transparent border border-stone-300 dark:border-stone-700 px-4 py-2 text-stone-600 dark:text-stone-400 focus:outline-none focus:border-stone-900 dark:focus:border-stone-100 cursor-pointer">
        <option value="terbaru" <?= $sort === 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
        <option value="terpopuler" <?= $sort === 'terpopuler' ? 'selected' : '' ?>>Terpopuler</option>
        <option value="termurah" <?= $sort === 'termurah' ? 'selected' : '' ?>>Termurah</option>
        <option value="termahal" <?= $sort === 'termahal' ? 'selected' : '' ?>>Termahal</option>
      </select>
    </div>

    <?php if (empty($products)): ?>
      <p class="text-center text-stone-400 py-20 text-sm">Belum ada produk di kategori ini.</p>
    <?php else: ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-8" id="productGrid">
      <?php foreach ($products as $i => $product):
        $discount = $product['original_price'] ? round((($product['original_price'] - $product['price']) / $product['original_price']) * 100) : 0;
      ?>
      <a href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>" class="group block reveal" style="transition-delay: <?= $i * 0.05 ?>s">
        <div class="relative aspect-[3/4] overflow-hidden bg-stone-100 dark:bg-stone-900 mb-4">
          <?php
          $img = $db->query("SELECT url FROM product_images WHERE product_id = {$product['id']} ORDER BY sort_order LIMIT 1")->fetch_assoc();
          ?>
          <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-700" style="background-image: url('<?= $img['url'] ?? '' ?>')"></div>
          <?php if ($product['is_new'] || $discount > 0 || $product['is_pre_order']): ?>
          <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            <?php if ($product['is_new']): ?><span class="bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 text-[10px] uppercase tracking-[0.15em] px-2.5 py-1">New</span><?php endif; ?>
            <?php if ($discount > 0): ?><span class="bg-signature text-white text-[10px] uppercase tracking-[0.15em] px-2.5 py-1">-<?= $discount ?>%</span><?php endif; ?>
            <?php if ($product['is_pre_order']): ?><span class="bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 text-[10px] uppercase tracking-[0.15em] px-2.5 py-1">Pre-Order</span><?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
        <div class="space-y-1">
          <h3 class="text-sm font-medium text-stone-900 dark:text-stone-100"><?= $product['name'] ?></h3>
          <p class="text-xs text-stone-500 uppercase tracking-wider"><?= $product['category_name'] ?></p>
          <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-stone-900 dark:text-stone-100"><?= rupiah($product['price']) ?></span>
            <?php if ($product['original_price']): ?><span class="text-xs text-stone-400 line-through"><?= rupiah($product['original_price']) ?></span><?php endif; ?>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
