<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "db_perpustakaan");

if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi Gagal"]));
}

$id = $_GET['id'] ?? null;
$kategori = $_GET['kategori'] ?? null;
$judul = $_GET['judul'] ?? null;
$stok_min = $_GET['stok_min'] ?? null;
$tahun_mulai = $_GET['tahun_mulai'] ?? null;
$tahun_akhir = $_GET['tahun_akhir'] ?? null;

$sql = "SELECT * FROM buku WHERE 1=1";

if ($id) $sql .= " AND id = $id";
if ($kategori) $sql .= " AND kategori = '$kategori'";
if ($judul) $sql .= " AND judul LIKE '%$judul%'";
if ($stok_min) $sql .= " AND stok >= $stok_min";
if ($tahun_mulai && $tahun_akhir) $sql .= " AND tahun_terbit BETWEEN $tahun_mulai AND $tahun_akhir";

$result = $conn->query($sql);
$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "owner" => "Fadil",
    "results" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT);
?>