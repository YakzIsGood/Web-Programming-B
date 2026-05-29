<?php
require 'koneksi.php';

$id = $_POST['id'];
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];

$stmt_old = $db->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_old->bind_param("i", $id);
$stmt_old->execute();
$res_old = $stmt_old->get_result();
$row_old = $res_old->fetch_assoc();
$foto_lama = $row_old['foto'];
$stmt_old->close();

$foto_baru = $foto_lama;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    if (empty($ext)) {
        $ext = 'png';
    }
    $foto_baru = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/upload_penulis/' . $foto_baru);
    
    if ($foto_lama !== 'default.png' && file_exists(__DIR__ . '/upload_penulis/' . $foto_lama)) {
        unlink(__DIR__ . '/upload_penulis/' . $foto_lama);
    }
}

if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt = $db->prepare("UPDATE penulis SET nama_depan = ?, nama_belakang = ?, user_name = ?, password = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nama_depan, $nama_belakang, $user_name, $password, $foto_baru, $id);
} else {
    $stmt = $db->prepare("UPDATE penulis SET nama_depan = ?, nama_belakang = ?, user_name = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nama_depan, $nama_belakang, $user_name, $foto_baru, $id);
}

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>