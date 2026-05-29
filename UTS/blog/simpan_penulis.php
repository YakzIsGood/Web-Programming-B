<?php
require 'koneksi.php';

$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$foto = 'default.png';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    if (empty($ext)) {
        $ext = 'png';
    }
    $foto = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/upload_penulis/' . $foto);
}

$stmt = $db->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $password, $foto);

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$db->close();
?>