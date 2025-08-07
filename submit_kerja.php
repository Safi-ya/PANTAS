<?php
require 'config.php';
if (!isset($_SESSION['murid'])) { header("Location: index.html"); exit; }
$murid_id = $_SESSION['murid']['id'];
$kerja_id = intval($_POST['kerja_id']);
$jawapan = trim($_POST['jawapan']);
if ($kerja_id && $jawapan) {
  $stmt = $conn->prepare("INSERT INTO serahan (murid_id, kerja_id, jawapan, tarikh_serah) VALUES (?, ?, ?, CURDATE())");
  $stmt->bind_param("iis", $murid_id, $kerja_id, $jawapan);
  $stmt->execute();
  echo "<script>alert('Tugasan dihantar!'); window.location.href='kerja_pelajar.php';</script>";
} else {
  echo "<script>alert('Maklumat tak lengkap!'); window.location.href='kerja_pelajar.php';</script>";
}
?>