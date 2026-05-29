<?php
$host = 'localhost';
$user = 'root';
$pass = ''; 
$database = 'db_blog'; 

$db = new mysqli($host, $user, $pass, $database);

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>