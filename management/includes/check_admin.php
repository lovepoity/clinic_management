<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: /403.php');
  exit();
}
