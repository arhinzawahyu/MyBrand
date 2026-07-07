<?php
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = getDB();
  $stmt = $db->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
  $stmt->bind_param('sss', $_POST['name'], $_POST['email'], $_POST['message']);
  $stmt->execute();
  header('Location: ' . SITE_URL . '/faq.php?sent=1');
  exit;
}
