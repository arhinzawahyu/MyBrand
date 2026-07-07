<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$id = $_GET['id'] ?? 0;
$cat = $db->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();
if (!$cat) redirect(SITE_URL . '/admin/categories.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $slug = strtolower(str_replace(' ', '-', $_POST['name']));
  $db->query("UPDATE categories SET name='{$_POST['name']}',slug='$slug',image='{$_POST['image']}' WHERE id=$id");
  $_SESSION['flash'] = 'Kategori diupdate.'; redirect(SITE_URL . '/admin/categories.php');
}
$title = 'Edit Kategori';
include __DIR__ . '/includes/header.php';
?>
<div class="max-w-lg mx-auto">
  <div class="card p-5 space-y-4">
    <h3 class="font-semibold text-stone-800 pb-3 border-b border-stone-100">Edit Kategori</h3>
    <form method="POST" class="space-y-3">
      <input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>" required class="input">
      <input type="url" name="image" value="<?= $cat['image'] ?>" class="input" placeholder="URL gambar">
      <div class="flex gap-3">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= SITE_URL ?>/admin/categories.php" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
