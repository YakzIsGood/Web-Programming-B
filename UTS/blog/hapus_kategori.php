<?php
require 'koneksi.php';

$id = $_POST['id'];

$stmt = $db->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>