<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Tambah Produk';
$categories = $db->query("SELECT * FROM categories ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $db->prepare("INSERT INTO products (name, slug, category_id, price, original_price, description, is_new, is_pre_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9-]/', '-', $_POST['name'])));
  $slug = preg_replace('/-+/', '-', $slug);
  $is_new = isset($_POST['is_new']) ? 1 : 0;
  $is_po = isset($_POST['is_pre_order']) ? 1 : 0;
  $original_price = $_POST['original_price'] ?: null;
  $stmt->bind_param('ssiiisii', $_POST['name'], $slug, $_POST['category_id'], $_POST['price'], $original_price, $_POST['description'], $is_new, $is_po);
  $stmt->execute();
  $pid = $db->insert_id;

  if (!empty($_POST['images'])) {
    $istmt = $db->prepare("INSERT INTO product_images (product_id, url, sort_order) VALUES (?, ?, ?)");
    foreach (array_filter($_POST['images']) as $i => $url) {
      $istmt->bind_param('isi', $pid, $url, $i);
      $istmt->execute();
    }
  }
  if (!empty($_POST['colors'])) {
    $cstmt = $db->prepare("INSERT INTO product_colors (product_id, name, hex) VALUES (?, ?, ?)");
    foreach ($_POST['colors'] as $c) {
      if (!empty($c['name']) && !empty($c['hex'])) {
        $cstmt->bind_param('iss', $pid, $c['name'], $c['hex']);
        $cstmt->execute();
      }
    }
  }
  if (!empty($_POST['sizes'])) {
    $sstmt = $db->prepare("INSERT INTO product_sizes (product_id, name) VALUES (?, ?)");
    foreach (array_filter($_POST['sizes']) as $s) {
      $sstmt->bind_param('is', $pid, $s);
      $sstmt->execute();
    }
  }

  $_SESSION['flash'] = 'Produk berhasil ditambahkan.';
  redirect(SITE_URL . '/admin/products.php');
}

include __DIR__ . '/includes/header.php';
?>

<form method="POST" class="max-w-3xl space-y-6">
  <?php if (isset($_SESSION['flash'])): ?>
    <div class="bg-green-900/30 border border-green-800 text-green-300 px-4 py-3 rounded-lg text-sm"><?= $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
  <?php endif; ?>

  <div class="card space-y-5">
    <h3 class="font-semibold">Informasi Produk</h3>

    <div>
      <label class="label">Nama Produk</label>
      <input type="text" name="name" required class="input" placeholder="Silhouette Tee">
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="label">Kategori</label>
        <select name="category_id" required class="select">
          <?php while ($c = $categories->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div>
        <label class="label">Harga (Rp)</label>
        <input type="number" name="price" required class="input" placeholder="189000">
      </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="label">Harga Original (Rp) <span class="text-stone-500">— opsional</span></label>
        <input type="number" name="original_price" class="input" placeholder="Kosongkan jika tidak diskon">
      </div>
      <div class="flex items-end gap-6 pb-2.5">
        <label class="flex items-center gap-2 text-sm text-stone-300 cursor-pointer">
          <input type="checkbox" name="is_new" value="1" class="accent-signature"> New Label
        </label>
        <label class="flex items-center gap-2 text-sm text-stone-300 cursor-pointer">
          <input type="checkbox" name="is_pre_order" value="1" class="accent-signature"> Pre-Order
        </label>
      </div>
    </div>

    <div>
      <label class="label">Deskripsi</label>
      <textarea name="description" rows="4" class="textarea" placeholder="Deskripsi produk..."></textarea>
    </div>
  </div>

  <div class="card space-y-3">
    <h3 class="font-semibold">Gambar <span class="text-stone-500 text-xs font-normal">(URL gambar, maks 4)</span></h3>
    <?php for ($i = 0; $i < 4; $i++): ?>
    <input type="url" name="images[]" class="input" placeholder="https://...gambar<?= $i+1 ?>.jpg">
    <?php endfor; ?>
  </div>

  <div class="card space-y-3">
    <h3 class="font-semibold">Warna</h3>
    <div id="colorFields">
      <div class="flex gap-3 mb-2">
        <input type="text" name="colors[0][name]" class="input flex-1" placeholder="Nama warna (Black)">
        <input type="text" name="colors[0][hex]" class="input w-32" placeholder="#0a0a0a">
      </div>
    </div>
    <button type="button" onclick="addColor()" class="btn btn-ghost text-xs">+ Tambah Warna</button>
  </div>

  <div class="card space-y-3">
    <h3 class="font-semibold">Ukuran</h3>
    <div class="flex flex-wrap gap-2" id="sizeFields">
      <?php foreach (['S','M','L','XL','XXL','One Size'] as $s): ?>
      <label class="flex items-center gap-1.5 text-sm text-stone-300 cursor-pointer">
        <input type="checkbox" name="sizes[]" value="<?= $s ?>" class="accent-signature"> <?= $s ?>
      </label>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="flex gap-3">
    <button type="submit" class="btn btn-primary">Simpan Produk</button>
    <a href="<?= SITE_URL ?>/admin/products.php" class="btn btn-ghost">Batal</a>
  </div>
</form>

<script>
function addColor() {
  const i = document.querySelectorAll('#colorFields .flex').length;
  const div = document.createElement('div');
  div.className = 'flex gap-3 mb-2';
  div.innerHTML = `
    <input type="text" name="colors[${i}][name]" class="input flex-1" placeholder="Nama warna">
    <input type="text" name="colors[${i}][hex]" class="input w-32" placeholder="#hex">
  `;
  document.getElementById('colorFields').appendChild(div);
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
