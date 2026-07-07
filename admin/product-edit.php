<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Edit Produk';

$id = $_GET['id'] ?? 0;
$product = $db->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
if (!$product) { $_SESSION['flash'] = 'Produk tidak ditemukan.'; redirect(SITE_URL . '/admin/products.php'); }

$categories = $db->query("SELECT * FROM categories ORDER BY name");
$images = $db->query("SELECT * FROM product_images WHERE product_id=$id ORDER BY sort_order");
$colors = $db->query("SELECT * FROM product_colors WHERE product_id=$id");
$existing_sizes = [];
$sizes = $db->query("SELECT * FROM product_sizes WHERE product_id=$id");
while ($s = $sizes->fetch_assoc()) $existing_sizes[] = $s['name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9-]/', '-', $_POST['name'])));
  $is_new = isset($_POST['is_new']) ? 1 : 0;
  $is_po = isset($_POST['is_pre_order']) ? 1 : 0;
  $op = $_POST['original_price'] ?: null;
  $db->query("UPDATE products SET name='{$_POST['name']}', slug='$slug', category_id={$_POST['category_id']}, price={$_POST['price']}, original_price=".($op??'NULL').", description='{$_POST['description']}', is_new=$is_new, is_pre_order=$is_po WHERE id=$id");
  $db->query("DELETE FROM product_images WHERE product_id=$id");
  $db->query("DELETE FROM product_colors WHERE product_id=$id");
  $db->query("DELETE FROM product_sizes WHERE product_id=$id");
  foreach (array_filter($_POST['images'] ?? []) as $i => $url) $db->query("INSERT INTO product_images (product_id,url,sort_order) VALUES ($id,'$url',$i)");
  foreach (($_POST['colors'] ?? []) as $c) { if (!empty($c['name']) && !empty($c['hex'])) $db->query("INSERT INTO product_colors (product_id,name,hex) VALUES ($id,'{$c['name']}','{$c['hex']}')"); }
  foreach (array_filter($_POST['sizes'] ?? []) as $s) $db->query("INSERT INTO product_sizes (product_id,name) VALUES ($id,'$s')");
  $_SESSION['flash'] = 'Produk diupdate.'; redirect(SITE_URL . '/admin/products.php');
}

include __DIR__ . '/includes/header.php';
?>

<form method="POST" class="max-w-3xl mx-auto space-y-6">
  <div class="card p-5 space-y-5">
    <h3 class="font-semibold text-stone-800 pb-3 border-b border-stone-100">Edit Produk</h3>
    <div class="grid md:grid-cols-2 gap-4">
      <div class="md:col-span-2"><label class="label">Nama</label><input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="input"></div>
      <div><label class="label">Kategori</label><select name="category_id" class="select"><?php while ($c = $categories->fetch_assoc()): ?><option value="<?= $c['id'] ?>" <?= $c['id']==$product['category_id']?'selected':'' ?>><?= $c['name'] ?></option><?php endwhile; ?></select></div>
      <div><label class="label">Harga</label><input type="number" name="price" value="<?= $product['price'] ?>" required class="input"></div>
      <div><label class="label">Original</label><input type="number" name="original_price" value="<?= $product['original_price'] ?>" class="input"></div>
      <div class="flex items-end gap-6 pb-1">
        <label class="flex items-center gap-2 text-sm cursor-pointer text-stone-600"><input type="checkbox" name="is_new" value="1" <?= $product['is_new']?'checked':'' ?> class="accent-signature w-4 h-4"> New</label>
        <label class="flex items-center gap-2 text-sm cursor-pointer text-stone-600"><input type="checkbox" name="is_pre_order" value="1" <?= $product['is_pre_order']?'checked':'' ?> class="accent-signature w-4 h-4"> PO</label>
      </div>
      <div class="md:col-span-2"><label class="label">Deskripsi</label><textarea name="description" rows="4" class="textarea"><?= htmlspecialchars($product['description']) ?></textarea></div>
    </div>
  </div>

  <div class="card p-5 space-y-3">
    <h3 class="font-semibold text-stone-800 pb-3 border-b border-stone-100">Gambar</h3>
    <?php for ($i = 0; $i < 4; $i++): $img = $images->fetch_assoc(); ?>
    <input type="url" name="images[]" class="input" value="<?= $img['url'] ?? '' ?>" placeholder="https://...">
    <?php endfor; ?>
  </div>

  <div class="card p-5 space-y-3">
    <h3 class="font-semibold text-stone-800 pb-3 border-b border-stone-100">Warna</h3>
    <div id="colorFields">
      <?php $i = 0; do { $c = $colors->fetch_assoc(); if (!$c) break; ?>
      <div class="flex gap-3 mb-2"><input type="text" name="colors[<?= $i ?>][name]" class="input flex-1" value="<?= $c['name'] ?>"><input type="text" name="colors[<?= $i ?>][hex]" class="input w-28" value="<?= $c['hex'] ?>"></div>
      <?php $i++; } while ($c); ?>
    </div>
    <button type="button" onclick="addColor()" class="btn btn-secondary text-xs">+ Warna</button>
  </div>

  <div class="card p-5 space-y-3">
    <h3 class="font-semibold text-stone-800 pb-3 border-b border-stone-100">Ukuran</h3>
    <div class="flex flex-wrap gap-3">
      <?php foreach (['S','M','L','XL','XXL','One Size'] as $s): ?>
      <label class="flex items-center gap-1.5 text-sm text-stone-600 cursor-pointer"><input type="checkbox" name="sizes[]" value="<?= $s ?>" <?= in_array($s,$existing_sizes)?'checked':'' ?> class="accent-signature w-4 h-4"> <?= $s ?></label>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="flex flex-col sm:flex-row gap-3">
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= SITE_URL ?>/admin/products.php" class="btn btn-secondary">Batal</a>
  </div>
</form>

<script>
function addColor() {
  const i = document.querySelectorAll('#colorFields .flex').length;
  const d = document.createElement('div'); d.className = 'flex gap-3 mb-2';
  d.innerHTML = `<input type="text" name="colors[${i}][name]" class="input flex-1" placeholder="Nama"><input type="text" name="colors[${i}][hex]" class="input w-28" placeholder="#hex">`;
  document.getElementById('colorFields').appendChild(d);
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
