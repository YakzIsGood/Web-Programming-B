<?php
require 'koneksi.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$id_penulis = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$isi = $_POST['isi'];

$stmt_old = $db->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt_old->bind_param("i", $id);
$stmt_old->execute();
$res_old = $stmt_old->get_result();
$row_old = $res_old->fetch_assoc();
$gambar_lama = $row_old['gambar'];
$stmt_old->close();

$gambar_baru = $gambar_lama;

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    if (empty($ext)) {
        $ext = 'png';
    }
    $gambar_baru = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . '/uploads_artikel/' . $gambar_baru);
    
    if (!empty($gambar_lama) && file_exists(__DIR__ . '/uploads_artikel/' . $gambar_lama)) {
        unlink(__DIR__ . '/uploads_artikel/' . $gambar_lama);
    }
}

$stmt = $db->prepare("UPDATE artikel SET judul = ?, isi = ?, gambar = ?, id_penulis = ?, id_kategori = ? WHERE id = ?");
$stmt->bind_param("sssiii", $judul, $isi, $gambar_baru, $id_penulis, $id_kategori, $id);

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>