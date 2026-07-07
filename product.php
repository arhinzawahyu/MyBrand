<?php
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$product = getProduct($slug);

if (!$product) {
  $title = 'Produk Tidak Ditemukan — LanggarBoy';
  include __DIR__ . '/includes/header.php';
  echo '<div class="pt-32 pb-20 text-center"><p class="text-stone-400">Produk tidak ditemukan.</p>';
  echo '<a href="' . SITE_URL . '/products.php" class="text-sm underline mt-4 inline-block">Kembali</a></div>';
  include __DIR__ . '/includes/footer.php';
  exit;
}

$db = getDB();
$related = getRelatedProducts($product['category_id'], $product['id']);
$discount = $product['original_price'] ? round((($product['original_price'] - $product['price']) / $product['original_price']) * 100) : 0;
$title = $product['name'] . ' — LanggarBoy';
include __DIR__ . '/includes/header.php';
?>

<div class="pt-28 pb-20">
  <div class="max-w-7xl mx-auto px-6">
    <a href="<?= SITE_URL ?>/products.php" class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.15em] text-stone-400 hover:text-stone-900 dark:hover:text-stone-100 transition-colors mb-8">
      <span class="text-lg leading-none">&larr;</span> Kembali
    </a>

    <div class="grid md:grid-cols-2 gap-10 md:gap-16 mb-20">
      <div class="reveal">
        <div class="relative aspect-[4/5] overflow-hidden bg-stone-100 dark:bg-stone-900">
          <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= $product['images'][0]['url'] ?? '' ?>')"></div>
        </div>
        <?php if (count($product['images']) > 1): ?>
        <div class="flex gap-3 mt-4">
          <?php foreach ($product['images'] as $i => $img): ?>
          <button class="w-20 h-20 bg-cover bg-center border-2 transition-all <?= $i === 0 ? 'border-stone-900 dark:border-stone-100' : 'border-transparent' ?>" style="background-image: url('<?= $img['url'] ?>')"></button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="flex flex-col reveal">
        <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-2"><?= $product['category_name'] ?></p>
        <h1 class="text-2xl md:text-4xl font-bold tracking-tight mb-3"><?= $product['name'] ?></h1>
        <div class="flex items-center gap-3 mb-6">
          <span class="text-xl font-semibold"><?= rupiah($product['price']) ?></span>
          <?php if ($product['original_price']): ?><span class="text-sm text-stone-400 line-through"><?= rupiah($product['original_price']) ?></span><?php endif; ?>
        </div>
        <p class="text-sm text-stone-600 dark:text-stone-400 leading-relaxed mb-8"><?= $product['description'] ?></p>

        <div class="mb-6">
          <p class="text-xs uppercase tracking-[0.15em] text-stone-500 mb-3">Warna</p>
          <div class="flex gap-3" id="colorOptions">
            <?php foreach ($product['colors'] as $i => $c): ?>
            <button data-color="<?= $c['hex'] ?>" data-name="<?= $c['name'] ?>" class="color-btn w-8 h-8 rounded-full border-2 transition-all <?= $i === 0 ? 'border-stone-900 dark:border-stone-100 scale-110' : 'border-stone-300 dark:border-stone-600' ?>" style="background-color: <?= $c['hex'] ?>">
              <span class="sr-only"><?= $c['name'] ?></span>
            </button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="mb-8">
          <p class="text-xs uppercase tracking-[0.15em] text-stone-500 mb-3">Size</p>
          <div class="flex gap-2 flex-wrap" id="sizeOptions">
            <?php foreach ($product['sizes'] as $s): ?>
            <button data-size="<?= $s['name'] ?>" class="size-btn min-w-[48px] h-10 text-xs uppercase tracking-[0.1em] border transition-all border-stone-300 dark:border-stone-700 text-stone-600 dark:text-stone-400 hover:border-stone-900 dark:hover:border-stone-100"><?= $s['name'] ?></button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="flex items-center gap-4 mb-8">
          <div class="flex border border-stone-300 dark:border-stone-700">
            <button id="qtyMinus" class="w-10 h-10 flex items-center justify-center text-sm hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors">-</button>
            <span id="qtyDisplay" class="w-10 h-10 flex items-center justify-center text-sm border-x border-stone-300 dark:border-stone-700">1</span>
            <button id="qtyPlus" class="w-10 h-10 flex items-center justify-center text-sm hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors">+</button>
          </div>
        </div>

        <button id="addToCartBtn" class="w-full bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 py-4 text-sm uppercase tracking-[0.15em] font-medium hover:bg-stone-700 dark:hover:bg-stone-300 transition-colors">
          <?= $product['is_pre_order'] ? 'Pre-Order Sekarang' : 'Tambah ke Keranjang' ?>
        </button>

        <div class="mt-6 pt-6 border-t border-stone-200 dark:border-stone-800">
          <details class="group">
            <summary class="text-xs uppercase tracking-[0.15em] text-stone-500 cursor-pointer flex items-center justify-between">Detail Produk <span class="transition-transform group-open:rotate-180 ml-2">▼</span></summary>
            <p class="mt-3 text-sm text-stone-600 dark:text-stone-400 leading-relaxed"><?= $product['description'] ?></p>
          </details>
          <details class="group mt-4">
            <summary class="text-xs uppercase tracking-[0.15em] text-stone-500 cursor-pointer flex items-center justify-between">Perawatan <span class="transition-transform group-open:rotate-180 ml-2">▼</span></summary>
            <p class="mt-3 text-sm text-stone-600 dark:text-stone-400 leading-relaxed">Cuci dengan air dingin. Jangan gunakan pemutih. Setrika dengan suhu rendah.</p>
          </details>
        </div>
      </div>
    </div>

    <?php if (!empty($related)): ?>
    <section>
      <div class="flex items-end justify-between mb-10">
        <div>
          <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-2">Related</p>
          <h2 class="text-xl md:text-3xl font-bold tracking-tight">Produk Lainnya</h2>
        </div>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-5 md:gap-8">
        <?php foreach ($related as $i => $p):
          $img = $db->query("SELECT url FROM product_images WHERE product_id = {$p['id']} ORDER BY sort_order LIMIT 1")->fetch_assoc();
        ?>
        <a href="<?= SITE_URL ?>/product.php?slug=<?= $p['slug'] ?>" class="group block reveal" style="transition-delay: <?= $i * 0.1 ?>s">
          <div class="relative aspect-[3/4] overflow-hidden bg-stone-100 dark:bg-stone-900 mb-4">
            <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-700" style="background-image: url('<?= $img['url'] ?? '' ?>')"></div>
          </div>
          <h3 class="text-sm font-medium text-stone-900 dark:text-stone-100"><?= $p['name'] ?></h3>
          <p class="text-xs text-stone-500 uppercase tracking-wider"><?= $p['category_name'] ?></p>
          <span class="text-sm font-medium text-stone-900 dark:text-stone-100"><?= rupiah($p['price']) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
  </div>
</div>

<script>
const productData = {
  id: <?= $product['id'] ?>,
  name: '<?= addslashes($product['name']) ?>',
  price: <?= $product['price'] ?>,
  slug: '<?= $product['slug'] ?>',
  isPreOrder: <?= $product['is_pre_order'] ? 'true' : 'false' ?>
};
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
