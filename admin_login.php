<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = trim($_POST['admin_user']);
  $pass = trim($_POST['admin_pass']);
  $stmt = $conn->prepare("SELECT id, nama FROM admin WHERE username=? AND password=?");
  $stmt->bind_param("ss", $user, $pass);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows === 1) {
    $_SESSION['admin'] = $res->fetch_assoc();
    header("Location: admin_dashboard.php"); exit;
  } else {
    echo "<script>alert('Login admin gagal!'); window.location.href='admin.html';</script>";
    exit;
  }
} else {
  header("Location: admin.html");
  exit;
}
?>