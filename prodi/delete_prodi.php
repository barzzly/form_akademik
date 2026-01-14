<?php
include "koneksi_akademik.php";

if (!isset($_GET['id'])) {
    header("Location: prodi.php");
    exit;
}

$id = (int) $_GET['id'];

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
//.
$stmt->close();
$db->close();
exit;
