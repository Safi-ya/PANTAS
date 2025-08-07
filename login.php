<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kod = trim($_POST['kod_sekolah']);
  $siri = trim($_POST['nombor_siri']);
  if (!$kod || !$siri) {
    echo "<script>alert('Isi semua maklumat!'); window.location.href='index.html';</script>";
    exit;
  }
  $stmt = $conn->prepare("SELECT * FROM murid WHERE kod_sekolah=? AND nombor_siri=?");
  $stmt->bind_param("ss", $kod, $siri);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows === 1) {
    $_SESSION['murid'] = $res->fetch_assoc();
    header("Location: dashboard.php"); exit;
  } else {
    echo "<script>alert('Kod atau nombor siri salah!'); window.location.href='index.html';</script>";
    exit;
  }
} else {
  header("Location: index.html");
  exit;
}
?>