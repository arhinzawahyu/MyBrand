<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$id = $_GET['id'] ?? 0;
$db->query("DELETE FROM products WHERE id=$id");
$_SESSION['flash'] = 'Produk berhasil dihapus.';
redirect(SITE_URL . '/admin/products.php');
