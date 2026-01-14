<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $sql = "DELETE FROM sukan WHERE idsukan = '$id'";

    if (mysqli_query($condb, $sql)) {
        echo "<script>alert('Sukan berjaya dipadam!');
            window.location.href='sukan-daftar.php';</script>";
    } else {
    echo "<script>alert('Ralat: " . mysqli_error($condb) . "');
         window.location.href='sukan-daftar.php';</script>";
    }
} else {
    header("Location: sukan-daftar.php");
}
?>