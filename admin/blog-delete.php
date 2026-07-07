<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$id = $_GET['id'] ?? 0;
$db->query("DELETE FROM blog_posts WHERE id=$id");
$_SESSION['flash'] = 'Artikel dihapus.';
redirect(SITE_URL . '/admin/blog.php');
