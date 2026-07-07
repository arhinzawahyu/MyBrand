<?php
require_once __DIR__ . '/../../includes/config.php';
if (!isAdmin()) {
  redirect(SITE_URL . '/admin/login.php');
}
