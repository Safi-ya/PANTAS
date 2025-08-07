<?php
require 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.html");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID murid tidak sah.");
}

$id = intval($_GET['id']);

// Padam rekod berkaitan dalam 'serahan'
$stmt1 = $conn->prepare("DELETE FROM serahan WHERE murid_id = ?");
$stmt1->bind_param("i", $id);
$stmt1->execute();

// (Tambah padam rekod lain jika ada, contohnya 'prestasi')

// Padam murid
$stmt2 = $conn->prepare("DELETE FROM murid WHERE id = ?");
$stmt2->bind_param("i", $id);
$stmt2->execute();

echo "<script>
        alert('Murid berjaya dipadam.');
        window.location.href = 'admin_dashboard.php';
      </script>";
exit;
