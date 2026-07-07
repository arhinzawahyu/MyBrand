<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();

$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

$_SESSION['flash'] = 'Produk berhasil dihapus.';
redirect(SITE_URL . '/admin/products.php');
