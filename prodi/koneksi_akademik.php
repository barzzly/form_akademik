<?php

$host = "localhost"; 
$user = "root";
$password = "";
$db_name = "db_akademik";


$db = new mysqli($host, $user, $password, $db_name);

//.
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>