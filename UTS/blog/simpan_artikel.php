<?php
require 'koneksi.php';

$judul = $_POST['judul'];
$id_penulis = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$isi = $_POST['isi'];

$hari_tanggal = date('Y-m-d'); 

$gambar = '';
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    if (empty($ext)) {
        $ext = 'png';
    }
    $gambar = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . '/uploads_artikel/' . $gambar);
}

$stmt = $db->prepare("INSERT INTO artikel (judul, isi, gambar, id_penulis, id_kategori, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiis", $judul, $isi, $gambar, $id_penulis, $id_kategori, $hari_tanggal);

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>