<?php
require 'koneksi.php';

$nama_kategori = $_POST['nama_kategori'];
$keterangan = $_POST['keterangan'];

$stmt = $db->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
$stmt->bind_param("ss", $nama_kategori, $keterangan);

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>