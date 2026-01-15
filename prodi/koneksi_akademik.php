<?php
// File koneksi yang sama dengan di folder mahasiswa
$host = "localhost"; 
$user = "root";
$password = "";
$db_name = "db_akademik";

$db = new mysqli($host, $user, $password, $db_name);

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

// Set charset untuk mencegah masalah karakter
$db->set_charset("utf8mb4");
?>