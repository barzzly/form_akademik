<?php
session_start();
// CEK LOGIN
if (!isset($_SESSION['nim'])) {
    header("Location: ../mahasiswa/login.php");
    exit;
}

include "koneksi_akademik.php";

if (!isset($_GET['id'])) {
    header("Location: prodi.php");
    exit;
}

$id = (int) $_GET['id'];

// Cek apakah prodi digunakan oleh mahasiswa
$check = $db->prepare("SELECT COUNT(*) as total FROM mahasiswa WHERE prodi_id = ?");
$check->bind_param("i", $id);
$check->execute();
$result = $check->get_result();
$row = $result->fetch_assoc();

if ($row['total'] > 0) {
    header("Location: prodi.php?pesan=prodi_terpakai");
    exit;
}

// Query delete prodi
$sql = "DELETE FROM prodi WHERE id = ?";
$stmt = $db->prepare($sql);

if (!$stmt) {
    die("Prepare gagal: " . $db->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: prodi.php?pesan=sukses_hapus");
} else {
    header("Location: prodi.php?pesan=gagal");
}

$stmt->close();
$db->close();
exit;
?>