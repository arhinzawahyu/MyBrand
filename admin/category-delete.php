<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$id = $_GET['id'] ?? 0;
$db->query("DELETE FROM categories WHERE id=$id");
$_SESSION['flash'] = 'Kategori dihapus.';
redirect(SITE_URL . '/admin/categories.php');
