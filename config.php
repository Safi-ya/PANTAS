<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'pantas');
if ($conn->connect_error) die("Sambungan gagal: " . $conn->connect_error);
?>