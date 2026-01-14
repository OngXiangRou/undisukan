<?php
session_start();
include('kawalan-admin.php');
include('connection.php');

// Dapatkan data dari borang
$id_calon = $_POST['id_calon'];
$nama_calon = mysqli_real_escape_string($condb, $_POST['nama_calon']);

// Kemaskini nama calon sahaja (tanpa ubah gambar)
$sql = "UPDATE calon SET nama_calon='$nama_calon' WHERE id_calon='$id_calon'";

if (mysqli_query($condb, $sql)) {
    echo "<script>alert('Kemaskini berjaya');
    window.location.href='calon-senarai.php';</script>";
} else {
    echo "<script>alert('Ralat: " . addslashes(mysqli_error($condb)) . "');
          window.history.back();</script>";
}