<?php
require 'koneksi.php';

$id = $_POST['id'];

$stmt_gambar = $db->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt_gambar->bind_param("i", $id);
$stmt_gambar->execute();
$res_gambar = $stmt_gambar->get_result();
$row_gambar = $res_gambar->fetch_assoc();
$gambar = $row_gambar['gambar'];
$stmt_gambar->close();

$stmt = $db->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if (!empty($gambar) && file_exists(__DIR__ . '/uploads_artikel/' . $gambar)) {
        unlink(__DIR__ . '/uploads_artikel/' . $gambar);
    }
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>