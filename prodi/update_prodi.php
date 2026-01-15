<?php
session_start();
// CEK LOGIN
if (!isset($_SESSION['nim'])) {
    header("Location: ../mahasiswa/login.php");
    exit();
}

include "koneksi_akademik.php";

if (!isset($_POST['update'])) {
    header("Location: prodi.php");
    exit;
}

// Ambil data dari form
$id         = (int) ($_POST['id'] ?? 0);
$nama_prodi = trim($_POST['nama_prodi'] ?? '');
$jenjang    = trim($_POST['jenjang'] ?? '');
$keterangan = trim($_POST['keterangan'] ?? '');

// Validasi
if ($id <= 0 || $nama_prodi === '' || $jenjang === '' || $keterangan === '') {
    header("Location: edit_prodi.php?id=$id&pesan=kosong");
    exit;
}

// Query update
$sql = "UPDATE prodi 
        SET nama_prodi = ?, jenjang = ?, keterangan = ?
        WHERE id = ?";

$stmt = $db->prepare($sql);

if (!$stmt) {
    die("Prepare gagal: " . $db->error);
}

$stmt->bind_param("sssi", $nama_prodi, $jenjang, $keterangan, $id);

if ($stmt->execute()) {
    header("Location: prodi.php?pesan=sukses_update");
} else {
    header("Location: edit_prodi.php?id=$id&pesan=gagal");
}

$stmt->close();
$db->close();
exit;
?>