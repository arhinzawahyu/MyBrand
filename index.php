<?php
require_once __DIR__ . '/includes/functions.php';
$title = 'LanggarBoy — Bukan Sekadar Baju';
$db = getDB();
$featured = getProducts(null, 'terbaru', 4);
$categories = getCategories();
include __DIR__ . '/includes/header.php';
?>

<section class="relative h-[80vh] min-h-[500px] max-h-[900px] w-full overflow-hidden" id="hero">
  <div class="absolute inset-0" id="heroSlide">
    <div class="absolute inset-0 bg-cover bg-center transition-all duration-700" id="heroBg"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
  </div>
  <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
    <div class="max-w-7xl mx-auto" id="heroText">
      <p class="text-xs uppercase tracking-[0.2em] text-white/70 mb-3">LanggarBoy Collection</p>
      <h2 class="text-4xl md:text-7xl font-bold text-white tracking-tight mb-4" id="heroTitle"></h2>
      <p class="text-white/80 text-sm md:text-base mb-6" id="heroSubtitle"></p>
      <a href="<?= SITE_URL ?>/products.php" class="inline-block bg-white text-stone-900 px-8 py-3 text-sm uppercase tracking-[0.15em] font-medium hover:bg-stone-200 transition-colors">Lihat Koleksi</a>
    </div>
  </div>
  <div class="absolute bottom-8 right-8 md:right-16 flex gap-2" id="heroDots"></div>
</section>

<div class="bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 py-3 overflow-hidden">
  <div class="animate-marquee flex whitespace-nowrap gap-12 text-xs uppercase tracking-[0.2em] font-medium">
    <span class="mx-6">Free shipping min. belanja Rp300k</span>
    <span class="mx-6">New drop setiap bulan</span>
    <span class="mx-6">Pre-order 1-2 minggu</span>
  </div>
</div>

<section class="max-w-7xl mx-auto px-6 py-20 md:py-28">
  <div class="flex items-end justify-between mb-12 reveal">
    <div>
      <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-2">Featured</p>
      <h2 class="text-2xl md:text-4xl font-bold tracking-tight">Koleksi Terbaru</h2>
    </div>
    <a href="<?= SITE_URL ?>/products.php" class="hidden md:inline-block text-sm uppercase tracking-[0.15em] border-b border-stone-900 dark:border-stone-100 pb-0.5 hover:text-stone-500 transition-colors">Lihat Semua</a>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-5 md:gap-8">
    <?php foreach ($featured as $i => $product):
      $discount = $product['original_price'] ? round((($product['original_price'] - $product['price']) / $product['original_price']) * 100) : 0;
      $colors = $product['id'];
    ?>
    <a href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>" class="group block reveal" style="transition-delay: <?= $i * 0.1 ?>s">
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
        <div class="flex gap-1.5 pt-1">
          <?php
          $colors = $db->query("SELECT hex FROM product_colors WHERE product_id = {$product['id']} LIMIT 4");
          while ($c = $colors->fetch_assoc()):
          ?>
          <span class="inline-block w-3.5 h-3.5 rounded-full border border-stone-300 dark:border-stone-600" style="background-color: <?= $c['hex'] ?>"></span>
          <?php endwhile; ?>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="max-w-7xl mx-auto px-6 pb-20 md:pb-28">
  <div class="flex items-end justify-between mb-12 reveal">
    <div>
      <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-2">Categories</p>
      <h2 class="text-2xl md:text-4xl font-bold tracking-tight">Jelajahi</h2>
    </div>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
    <?php foreach ($categories as $i => $cat): ?>
    <a href="<?= SITE_URL ?>/products.php?cat=<?= $cat['slug'] ?>" class="group block reveal" style="transition-delay: <?= $i * 0.1 ?>s">
      <div class="relative aspect-[4/5] overflow-hidden bg-stone-100 dark:bg-stone-900">
        <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-700" style="background-image: url('<?= $cat['image'] ?>')"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        <div class="absolute bottom-4 left-4">
          <h3 class="text-lg font-bold text-white"><?= $cat['name'] ?></h3>
          <p class="text-xs text-white/70"><?= $cat['product_count'] ?> produk</p>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-stone-100 dark:bg-stone-900 py-20 md:py-28 reveal">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-4">LanggarBoy</p>
    <h2 class="text-3xl md:text-6xl font-bold tracking-tight leading-tight max-w-3xl mx-auto">Dibuat untuk yang <span class="text-signature">berani beda</span></h2>
    <p class="mt-6 text-stone-500 dark:text-stone-400 max-w-md mx-auto text-sm leading-relaxed">Setiap jahitan adalah perlawanan. Setiap koleksi adalah statement.</p>
    <a href="<?= SITE_URL ?>/about.php" class="inline-block mt-10 bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 px-8 py-3 text-sm uppercase tracking-[0.15em] font-medium hover:bg-stone-700 dark:hover:bg-stone-300 transition-colors">Tentang Kami</a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
