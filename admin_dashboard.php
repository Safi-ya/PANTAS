<?php
require 'config.php';

// Semak jika admin telah log masuk
if (!isset($_SESSION['admin'])) {
    header("Location: admin.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #D0D8BC;
      margin: 0;
      color: #000000;
    }

    header {
      background-color: #6A7D40;
      color: white;
      padding: 2rem;
      text-align: center;
    }

    nav {
      background-color: #5B624C;
      display: flex;
      justify-content: center;
      gap: 1rem;
      padding: 1rem;
    }

    nav a {
      color: #FFFFFF;
      text-decoration: none;
      background-color: #6A7D40;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    nav a:hover {
      background-color: #636B53;
      color: #D0D8BC;
    }

    main {
      max-width: 1000px;
      margin: 2rem auto;
      background: #F9F9F9;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #6A7D40;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 0.8rem;
      border: 1px solid #636B53;
      text-align: left;
    }

    th {
      background-color: #5B624C;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #EFEFEF;
    }

    .btn {
      padding: 0.4rem 0.7rem;
      background-color: #6A7D40;
      color: #FFFFFF;
      border-radius: 5px;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .btn:hover {
      background-color: #636B53;
      color: #D0D8BC;
    }

    footer {
      text-align: center;
      background-color: #5B624C;
      color: #D0D8BC;
      padding: 1rem;
      margin-top: 3rem;
    }
  </style>
</head>
<body>

<header>
  <h1>Dashboard Admin</h1>
</header>

<main>
  <nav>
    <a href="tambah_kerja.php">Tambah Tugasan</a>
    <a href="rekod_jawapan.php">Rekod Jawapan</a>
    <a href="nilai_kerja.php">Penilaian Tugasan</a>
    <a href="logout.php">Log Keluar</a>
  </nav>

  <h2>Senarai Murid</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Kod Sekolah</th>
      <th>Nombor Siri</th>
      <th>Jantina</th>
      <th>Kelas</th>
      <th>Aksi</th>
    </tr>
    <?php
    $res = $conn->query("SELECT * FROM murid ORDER BY nama ASC");
    while ($r = $res->fetch_assoc()) {
      echo "<tr>
        <td>{$r['id']}</td>
        <td>" . htmlspecialchars($r['nama']) . "</td>
        <td>" . htmlspecialchars($r['kod_sekolah']) . "</td>
        <td>" . htmlspecialchars($r['nombor_siri']) . "</td>
        <td>" . htmlspecialchars($r['jantina'] ?? '-') . "</td>
        <td>" . htmlspecialchars($r['kelas'] ?? '-') . "</td>
        <td>
          <a class='btn' href='delete_murid.php?id={$r['id']}' onclick=\"return confirm('Padam murid ini?');\">Padam</a>
        </td>
      </tr>";
    }
    ?>
  </table>
</main>

<footer>
  &copy; 2025 PANTAS
</footer>

</body>
</html>