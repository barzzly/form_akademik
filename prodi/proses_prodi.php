<?php
include "koneksi_akademik.php";

if (!isset($_POST['submit'])) {
    header("Location: prodi.php");
    exit;
}

// Ambil & rapikan input
$nama_prodi = trim($_POST['nama_prodi'] ?? '');
$jenjang    = trim($_POST['jenjang'] ?? '');
$keterangan = trim($_POST['keterangan'] ?? '');
//.
// Validasi
if ($nama_prodi === '' || $jenjang === '' || $keterangan === '') {
    header("Location: create_prodi.php?pesan=kosong");
    exit;
}

// Query insert
$sql = "INSERT INTO prodi (nama_prodi, jenjang, keterangan) VALUES (?, ?, ?)";
$stmt = $db->prepare($sql);

if (!$stmt) {
    die("Prepare gagal: " . $db->error);
}

// Bind & eksekusi
$stmt->bind_param("sss", $nama_prodi, $jenjang, $keterangan);

if ($stmt->execute()) {
    header("Location: prodi.php?pesan=sukses_tambah");
} else {
    header("Location: create_prodi.php?pesan=gagal");
}

$stmt->close();
$db->close();
exit;
