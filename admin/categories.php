<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Categories';
$categories = $db->query("SELECT c.*, (SELECT COUNT(*) FROM products WHERE category_id=c.id) as product_count FROM categories c ORDER BY c.id");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
  $slug = strtolower(str_replace(' ', '-', $_POST['name']));
  $stmt = $db->prepare("INSERT INTO categories (name, slug, image) VALUES (?, ?, ?)");
  $stmt->bind_param('sss', $_POST['name'], $slug, $_POST['image']);
  $stmt->execute();
  $_SESSION['flash'] = 'Kategori ditambahkan.';
  redirect(SITE_URL . '/admin/categories.php');
}

include __DIR__ . '/includes/header.php';
?>

<div class="grid md:grid-cols-3 gap-8">
  <div class="card md:col-span-2 p-0 overflow-hidden">
    <table class="w-full">
      <thead>
        <tr class="border-b border-stone-800 bg-stone-900/50">
          <th class="table-header">Nama</th>
          <th class="table-header">Slug</th>
          <th class="table-header">Produk</th>
          <th class="table-header text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($c = $categories->fetch_assoc()): ?>
        <tr class="border-b border-stone-800/50 hover:bg-stone-800/30">
          <td class="table-cell font-medium"><?= $c['name'] ?></td>
          <td class="table-cell text-stone-400"><?= $c['slug'] ?></td>
          <td class="table-cell"><?= $c['product_count'] ?></td>
          <td class="table-cell text-right">
            <a href="<?= SITE_URL ?>/admin/category-edit.php?id=<?= $c['id'] ?>" class="btn btn-ghost text-xs">Edit</a>
            <a href="<?= SITE_URL ?>/admin/category-delete.php?id=<?= $c['id'] ?>" class="btn btn-ghost text-xs text-red-400" onclick="return confirm('Hapus kategori?')">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <div class="card space-y-4">
    <h3 class="font-semibold">Tambah Kategori</h3>
    <form method="POST">
      <div class="space-y-3">
        <input type="text" name="name" required class="input" placeholder="Nama kategori">
        <input type="url" name="image" class="input" placeholder="URL gambar (opsional)">
        <button type="submit" name="add" class="btn btn-primary w-full">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
