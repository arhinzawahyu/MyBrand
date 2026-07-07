<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Categories';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
  $slug = strtolower(str_replace(' ', '-', $_POST['name']));
  $db->query("INSERT INTO categories (name,slug,image) VALUES ('{$_POST['name']}','$slug','{$_POST['image']}')");
  $_SESSION['flash'] = 'Kategori ditambahkan.'; redirect(SITE_URL . '/admin/categories.php');
}

$categories = $db->query("SELECT c.*,(SELECT COUNT(*) FROM products WHERE category_id=c.id) as product_count FROM categories c ORDER BY c.id");
include __DIR__ . '/includes/header.php';
?>

<div class="grid lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full min-w-[400px]">
        <thead><tr class="bg-stone-50 border-b border-stone-200"><th class="table-header">Nama</th><th class="table-header hidden sm:table-cell">Slug</th><th class="table-header">Produk</th><th class="table-header text-right">Aksi</th></tr></thead>
        <tbody>
          <?php while ($c = $categories->fetch_assoc()): ?>
          <tr class="border-t border-stone-100 hover:bg-stone-50/50">
            <td class="table-cell font-medium text-stone-800"><?= $c['name'] ?></td>
            <td class="table-cell hidden sm:table-cell text-stone-500 font-mono text-xs"><?= $c['slug'] ?></td>
            <td class="table-cell text-stone-600"><?= $c['product_count'] ?></td>
            <td class="table-cell text-right whitespace-nowrap">
              <a href="<?= SITE_URL ?>/admin/category-edit.php?id=<?= $c['id'] ?>" class="btn btn-ghost text-xs py-1">Edit</a>
              <a href="<?= SITE_URL ?>/admin/category-delete.php?id=<?= $c['id'] ?>" class="btn btn-ghost text-xs py-1 text-red-500 hover:text-red-700 hover:bg-red-50" onclick="return confirm('Hapus kategori?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card p-5 h-fit">
    <h3 class="font-semibold text-stone-800 mb-4">Tambah Kategori</h3>
    <form method="POST" class="space-y-3">
      <input type="text" name="name" required class="input" placeholder="Nama kategori">
      <input type="url" name="image" class="input" placeholder="URL gambar (opsional)">
      <button type="submit" name="add" class="btn btn-primary w-full">Simpan</button>
    </form>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
