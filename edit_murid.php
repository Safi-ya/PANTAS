<?php
require 'config.php';

// Semak sama ada admin sudah log masuk
if (!isset($_SESSION['admin'])) {
    header("Location: admin.html");
    exit;
}

// Semak parameter ID murid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID murid tidak sah.");
}

$id = intval($_GET['id']);

// Dapatkan data murid
$stmt = $conn->prepare("SELECT * FROM murid WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Murid tidak dijumpai.");
}

$murid = $result->fetch_assoc();

// Proses jika admin submit borang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $kod_sekolah = trim($_POST['kod_sekolah']);
    $nombor_siri = trim($_POST['nombor_siri']);
    $jantina = trim($_POST['jantina']);
    $tarikh_lahir = $_POST['tarikh_lahir'];
    $kelas = trim($_POST['kelas']);

    if ($nama && $kod_sekolah && $nombor_siri) {
        $update = $conn->prepare("UPDATE murid SET nama=?, kod_sekolah=?, nombor_siri=?, jantina=?, tarikh_lahir=?, kelas=? WHERE id=?");
        $update->bind_param("ssssssi", $nama, $kod_sekolah, $nombor_siri, $jantina, $tarikh_lahir, $kelas, $id);
        $update->execute();

        echo "<script>alert('Maklumat murid dikemaskini.'); window.location.href='admin_dashboard.php';</script>";
        exit;
    } else {
        $error = "Sila isi semua maklumat penting.";
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Edit Murid</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Edit Maklumat Murid</h1></header>
<main>
  <?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <label>Nama:</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($murid['nama']) ?>" required>

    <label>Kod Sekolah:</label>
    <input type="text" name="kod_sekolah" value="<?= htmlspecialchars($murid['kod_sekolah']) ?>" required>

    <label>Nombor Siri:</label>
    <input type="text" name="nombor_siri" value="<?= htmlspecialchars($murid['nombor_siri']) ?>" required>

    <label>Jantina:</label>
    <select name="jantina">
      <option value="" <?= $murid['jantina'] == '' ? 'selected' : '' ?>>- Pilih -</option>
      <option value="Lelaki" <?= $murid['jantina'] == 'Lelaki' ? 'selected' : '' ?>>Lelaki</option>
      <option value="Perempuan" <?= $murid['jantina'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
    </select>

    <label>Tarikh Lahir:</label>
    <input type="date" name="tarikh_lahir" value="<?= htmlspecialchars($murid['tarikh_lahir']) ?>">

    <label>Kelas:</label>
    <input type="text" name="kelas" value="<?= htmlspecialchars($murid['kelas']) ?>">

    <button type="submit">Simpan Perubahan</button>
  </form>

  <p><a href="admin_dashboard.php">← Kembali ke Dashboard</a></p>
</main>
<footer>&copy; 2025 PANTAS</footer>
</body>
</html>