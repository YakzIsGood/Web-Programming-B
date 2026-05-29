<?php
require 'koneksi.php';

$id = $_POST['id'];

$stmt = $db->prepare("SELECT * FROM kategori_artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($data);

$stmt->close();
$db->close();
?>