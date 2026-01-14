<?php
session_start();
include('kawalan-admin.php');
include('connection.php');
include("header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_calon = $_POST['id_calon'];
    $nama = $_POST['nama_calon'];

    // Urus gambar
    $nama_gambar = $_FILES['gambar']['name'];
    $sementara = $_FILES['gambar']['tmp_name'];
    $lokasi = 'gambar/' . basename($nama_gambar);

    if (move_uploaded_file($sementara, $lokasi)) {
        $query = "INSERT INTO calon (id_calon, nama_calon, gambar)
                  VALUES ('$id_calon','$nama','$lokasi')";
        if (mysqli_query($condb, $query)) {
            echo "<script>alert('Pendafataran berjaya!');
                window.location.href='calon-senarai.php';</script>";
        } else {
            // Semak jika ralat kerana Duplicate entry
            if (mysqli_errno($condb) == 1062) {
                echo "<script>
                alert('ID calon sudah didaftarkan oleh pengguna lain.Sila guna ID lain.');
                </script>";
            } else {
                echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
            } 
        }
    } else {
        echo "<script> alert('Gaagal memuat naik gambar.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Calon</title>
</head>
<body>
    <h2>DAFTAR CALON PERTANDINGAN</h2>
    <form action="" method="POST" enctype="multipart/form-data">

        ID Calon:<br>
        <input type="text" name="id_calon" required><br><br>

        Nama Calon:<br>
        <input type="text" name="nama_calon" required><br><br>

        Muat Naik Gambar:<br>
        <input type="file" name="gambar" accept="image/*" required><br><br>

        <input type="submit" value="DAFTAR">
    </form>
</body>
</html>