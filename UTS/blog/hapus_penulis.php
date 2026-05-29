<?php
require 'koneksi.php';

$id = $_POST['id'];

$stmt_foto = $db->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_foto->bind_param("i", $id);
$stmt_foto->execute();
$res_foto = $stmt_foto->get_result();
$row_foto = $res_foto->fetch_assoc();
$foto = $row_foto['foto'];
$stmt_foto->close();

$stmt = $db->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($foto !== 'default.png' && file_exists(__DIR__ . '/upload_penulis/' . $foto)) {
        unlink(__DIR__ . '/upload_penulis/' . $foto);
    }
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>