<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Edit Artikel';

$id = $_GET['id'] ?? 0;
$post = $db->query("SELECT * FROM blog_posts WHERE id=$id")->fetch_assoc();
if (!$post) redirect(SITE_URL . '/admin/blog.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9-]/', '-', $_POST['title'])));
  $slug = preg_replace('/-+/', '-', $slug);
  $stmt = $db->prepare("UPDATE blog_posts SET title=?, slug=?, excerpt=?, content=?, image=? WHERE id=?");
  $stmt->bind_param('sssssi', $_POST['title'], $slug, $_POST['excerpt'], $_POST['content'], $_POST['image'], $id);
  $stmt->execute();
  $_SESSION['flash'] = 'Artikel diupdate.';
  redirect(SITE_URL . '/admin/blog.php');
}

include __DIR__ . '/includes/header.php';
?>

<form method="POST" class="max-w-3xl space-y-6">
  <div class="card space-y-4">
    <h3 class="font-semibold">Edit Artikel</h3>
    <div>
      <label class="label">Judul</label>
      <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required class="input">
    </div>
    <div>
      <label class="label">URL Gambar</label>
      <input type="url" name="image" value="<?= $post['image'] ?>" class="input">
    </div>
    <div>
      <label class="label">Excerpt</label>
      <textarea name="excerpt" rows="2" class="textarea"><?= htmlspecialchars($post['excerpt']) ?></textarea>
    </div>
    <div>
      <label class="label">Konten</label>
      <textarea name="content" rows="10" class="textarea font-mono text-xs"><?= htmlspecialchars($post['content']) ?></textarea>
    </div>
  </div>
  <div class="flex gap-3">
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= SITE_URL ?>/admin/blog.php" class="btn btn-ghost">Batal</a>
  </div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
