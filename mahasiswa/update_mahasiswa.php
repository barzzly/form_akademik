<?php
include "koneksi_akademik.php";

if (isset($_POST['update'])) {

    $nim        = $_POST['nim'];
    $nama       = $_POST['nama_mahasiswa'];
    $prodi_id   = $_POST['prodi_id'];
    $tgl        = $_POST['tanggal_lahir'];
    $alamat     = $_POST['alamat'];


    if (empty($nim) || empty($nama) || empty($prodi_id) || empty($tgl) || empty($alamat)) {
        header("Location: edit_mahasiswa.php?nim=$nim&pesan=kosong");
        exit();
    }

    // Query Update (PAKAI prodi_id)
    $sql = "UPDATE mahasiswa 
            SET nama_mahasiswa = ?, 
                prodi_id = ?, 
                tanggal_lahir = ?, 
                alamat = ? 
            WHERE nim = ?";

    $stmt = $db->prepare($sql);

    if ($stmt) {
        // s = string, i = integer
        $stmt->bind_param("sissi", $nama, $prodi_id, $tgl, $alamat, $nim);

        if ($stmt->execute()) {
            header("Location: mahasiswa.php?pesan=sukses_update");
            exit();
        } else {
            header("Location: mahasiswa.php?pesan=gagal");
            exit();
        }

        $stmt->close();
    } else {
        echo "Error database: " . $db->error;
    }
} else {
    header("Location: mahasiswa.php");
    exit();
}

$db->close();
?>
