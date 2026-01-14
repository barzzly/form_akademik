<?php
include "koneksi_akademik.php";

if (!isset($_GET['nim'])) {
    header("Location: index.php");
    exit;
}

$nim = (int) $_GET['nim'];

$stmt = $db->prepare("DELETE FROM mahasiswa WHERE nim = ?");

if (!$stmt) {
    die("Prepare gagal: " . $db->error);
}

$stmt->bind_param("i", $nim);
//.
if ($stmt->execute()) {
    header("Location: index.php?pesan=sukses_hapus");
    exit;
} else {
    header("Location: index.php?pesan=gagal");
    exit;
}

$stmt->close();
$db->close();
