<?php
require_once __DIR__ . '/config.php';

function getCategories() {
  $db = getDB();
  return $db->query("SELECT * FROM categories ORDER BY id")->fetch_all(MYSQLI_ASSOC);
}

function getProducts($category_slug = null, $sort = 'terbaru', $limit = null) {
  $db = getDB();
  $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug
          FROM products p JOIN categories c ON p.category_id = c.id";
  $params = [];
  $types = '';

  if ($category_slug && $category_slug !== 'all') {
    $sql .= " WHERE c.slug = ?";
    $params[] = $category_slug;
    $types .= 's';
  }

  switch ($sort) {
    case 'termurah': $sql .= " ORDER BY p.price ASC"; break;
    case 'termahal': $sql .= " ORDER BY p.price DESC"; break;
    default: $sql .= " ORDER BY p.is_new DESC, p.created_at DESC";
  }

  if ($limit) {
    $sql .= " LIMIT ?";
    $params[] = $limit;
    $types .= 'i';
  }

  $stmt = $db->prepare($sql);
  if ($params) $stmt->bind_param($types, ...$params);
  $stmt->execute();
  return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getProduct($slug) {
  $db = getDB();
  $stmt = $db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug
                        FROM products p JOIN categories c ON p.category_id = c.id
                        WHERE p.slug = ?");
  $stmt->bind_param('s', $slug);
  $stmt->execute();
  $product = $stmt->get_result()->fetch_assoc();
  if (!$product) return null;

  $pid = $product['id'];
  $product['images'] = $db->query("SELECT url FROM product_images WHERE product_id = $pid ORDER BY sort_order")->fetch_all(MYSQLI_ASSOC);
  $product['colors'] = $db->query("SELECT name, hex FROM product_colors WHERE product_id = $pid")->fetch_all(MYSQLI_ASSOC);
  $product['sizes'] = $db->query("SELECT name FROM product_sizes WHERE product_id = $pid")->fetch_all(MYSQLI_ASSOC);

  return $product;
}

function getRelatedProducts($category_id, $exclude_id, $limit = 4) {
  $db = getDB();
  $stmt = $db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug
                        FROM products p JOIN categories c ON p.category_id = c.id
                        WHERE p.category_id = ? AND p.id != ? ORDER BY RAND() LIMIT ?");
  $stmt->bind_param('iii', $category_id, $exclude_id, $limit);
  $stmt->execute();
  return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getBlogPosts() {
  $db = getDB();
  return $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
}

function createOrder($data, $items) {
  $db = getDB();
  $stmt = $db->prepare("INSERT INTO orders (customer_name, email, phone, address, notes, total, status)
                        VALUES (?, ?, ?, ?, ?, ?, 'pending')");
  $stmt->bind_param('sssssi', $data['name'], $data['email'], $data['phone'], $data['address'], $data['notes'], $data['total']);
  $stmt->execute();
  $order_id = $db->insert_id;

  $itemStmt = $db->prepare("INSERT INTO order_items (order_id, product_id, product_name, size, color, quantity, price)
                             VALUES (?, ?, ?, ?, ?, ?, ?)");
  foreach ($items as $item) {
    $itemStmt->bind_param('iissiii', $order_id, $item['product_id'], $item['product_name'], $item['size'], $item['color'], $item['quantity'], $item['price']);
    $itemStmt->execute();
  }
  return $order_id;
}
