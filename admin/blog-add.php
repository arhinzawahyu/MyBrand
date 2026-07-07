<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Tambah Artikel';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9-]/', '-', $_POST['title'])));
  $slug = preg_replace('/-+/', '-', $slug);
  $db->query("INSERT INTO blog_posts (title,slug,excerpt,content,image) VALUES ('{$_POST['title']}','$slug','{$_POST['excerpt']}','{$_POST['content']}','{$_POST['image']}')");
  $_SESSION['flash'] = 'Artikel ditambahkan.'; redirect(SITE_URL . '/admin/blog.php');
}

include __DIR__ . '/includes/header.php';
?>

<form method="POST" class="max-w-3xl mx-auto space-y-6">
  <div class="card p-5 space-y-4">
    <h3 class="font-semibold text-stone-800 pb-3 border-b border-stone-100">Tambah Artikel</h3>
    <div><label class="label">Judul</label><input type="text" name="title" required class="input" placeholder="Judul artikel"></div>
    <div><label class="label">URL Gambar</label><input type="url" name="image" class="input" placeholder="https://..."></div>
    <div><label class="label">Excerpt</label><textarea name="excerpt" rows="2" class="textarea" placeholder="Ringkasan..."></textarea></div>
    <div><label class="label">Konten</label><textarea name="content" rows="10" class="textarea font-mono text-xs" placeholder="Konten artikel..."></textarea></div>
  </div>
  <div class="flex flex-col sm:flex-row gap-3">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= SITE_URL ?>/admin/blog.php" class="btn btn-secondary">Batal</a>
  </div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
