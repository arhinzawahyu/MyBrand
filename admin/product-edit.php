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
$sizes = $db->query("SELECT * FROM product_sizes WHERE product_id=$id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9-]/', '-', $_POST['name'])));
  $slug = preg_replace('/-+/', '-', $slug);
  $is_new = isset($_POST['is_new']) ? 1 : 0;
  $is_po = isset($_POST['is_pre_order']) ? 1 : 0;
  $original_price = $_POST['original_price'] ?: null;

  $stmt = $db->prepare("UPDATE products SET name=?, slug=?, category_id=?, price=?, original_price=?, description=?, is_new=?, is_pre_order=? WHERE id=?");
  $stmt->bind_param('ssiiisiii', $_POST['name'], $slug, $_POST['category_id'], $_POST['price'], $original_price, $_POST['description'], $is_new, $is_po, $id);
  $stmt->execute();

  $db->query("DELETE FROM product_images WHERE product_id=$id");
  $db->query("DELETE FROM product_colors WHERE product_id=$id");
  $db->query("DELETE FROM product_sizes WHERE product_id=$id");

  if (!empty($_POST['images'])) {
    $istmt = $db->prepare("INSERT INTO product_images (product_id, url, sort_order) VALUES (?, ?, ?)");
    foreach (array_filter($_POST['images']) as $i => $url) {
      $istmt->bind_param('isi', $id, $url, $i);
      $istmt->execute();
    }
  }
  if (!empty($_POST['colors'])) {
    $cstmt = $db->prepare("INSERT INTO product_colors (product_id, name, hex) VALUES (?, ?, ?)");
    foreach ($_POST['colors'] as $c) {
      if (!empty($c['name']) && !empty($c['hex'])) {
        $cstmt->bind_param('iss', $id, $c['name'], $c['hex']);
        $cstmt->execute();
      }
    }
  }
  if (!empty($_POST['sizes'])) {
    $sstmt = $db->prepare("INSERT INTO product_sizes (product_id, name) VALUES (?, ?)");
    foreach (array_filter($_POST['sizes']) as $s) {
      $sstmt->bind_param('is', $id, $s);
      $sstmt->execute();
    }
  }

  $_SESSION['flash'] = 'Produk berhasil diupdate.';
  redirect(SITE_URL . '/admin/products.php');
}

include __DIR__ . '/includes/header.php';

$existing_sizes = [];
while ($s = $sizes->fetch_assoc()) $existing_sizes[] = $s['name'];
?>

<form method="POST" class="max-w-3xl space-y-6">
  <div class="card space-y-5">
    <h3 class="font-semibold">Edit Produk</h3>

    <div>
      <label class="label">Nama Produk</label>
      <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="input">
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="label">Kategori</label>
        <select name="category_id" required class="select">
          <?php while ($c = $categories->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>" <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div>
        <label class="label">Harga (Rp)</label>
        <input type="number" name="price" value="<?= $product['price'] ?>" required class="input">
      </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="label">Harga Original</label>
        <input type="number" name="original_price" value="<?= $product['original_price'] ?>" class="input">
      </div>
      <div class="flex items-end gap-6 pb-2.5">
        <label class="flex items-center gap-2 text-sm text-stone-300 cursor-pointer">
          <input type="checkbox" name="is_new" value="1" <?= $product['is_new'] ? 'checked' : '' ?> class="accent-signature"> New
        </label>
        <label class="flex items-center gap-2 text-sm text-stone-300 cursor-pointer">
          <input type="checkbox" name="is_pre_order" value="1" <?= $product['is_pre_order'] ? 'checked' : '' ?> class="accent-signature"> PO
        </label>
      </div>
    </div>

    <div>
      <label class="label">Deskripsi</label>
      <textarea name="description" rows="4" class="textarea"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>
  </div>

  <div class="card space-y-3">
    <h3 class="font-semibold">Gambar</h3>
    <?php for ($i = 0; $i < 4; $i++):
      $img = $images->fetch_assoc();
    ?>
    <input type="url" name="images[]" class="input" placeholder="https://..." value="<?= $img['url'] ?? '' ?>">
    <?php endfor; ?>
  </div>

  <div class="card space-y-3">
    <h3 class="font-semibold">Warna</h3>
    <div id="colorFields">
      <?php
      $i = 0;
      do {
        $c = $colors->fetch_assoc();
        if (!$c) break;
      ?>
      <div class="flex gap-3 mb-2">
        <input type="text" name="colors[<?= $i ?>][name]" class="input flex-1" value="<?= $c['name'] ?>">
        <input type="text" name="colors[<?= $i ?>][hex]" class="input w-32" value="<?= $c['hex'] ?>">
      </div>
      <?php $i++; } while ($c); ?>
    </div>
    <button type="button" onclick="addColor()" class="btn btn-ghost text-xs">+ Warna</button>
  </div>

  <div class="card space-y-3">
    <h3 class="font-semibold">Ukuran</h3>
    <div class="flex flex-wrap gap-2">
      <?php foreach (['S','M','L','XL','XXL','One Size'] as $s): ?>
      <label class="flex items-center gap-1.5 text-sm text-stone-300 cursor-pointer">
        <input type="checkbox" name="sizes[]" value="<?= $s ?>" <?= in_array($s, $existing_sizes) ? 'checked' : '' ?> class="accent-signature"> <?= $s ?>
      </label>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="flex gap-3">
    <button type="submit" class="btn btn-primary">Update Produk</button>
    <a href="<?= SITE_URL ?>/admin/products.php" class="btn btn-ghost">Batal</a>
  </div>
</form>

<script>
function addColor() {
  const i = document.querySelectorAll('#colorFields .flex').length;
  const div = document.createElement('div');
  div.className = 'flex gap-3 mb-2';
  div.innerHTML = `<input type="text" name="colors[${i}][name]" class="input flex-1" placeholder="Nama"><input type="text" name="colors[${i}][hex]" class="input w-32" placeholder="#hex">`;
  document.getElementById('colorFields').appendChild(div);
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
