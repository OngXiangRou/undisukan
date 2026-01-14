<?php
session_start();
include('connection.php');
include('kawalan-biasa.php');

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['undi'])) {
    $nokp = mysqli_real_escape_string($condb,$_POST['nokp']);
    $undi = $_POST['undi']; // undi[id_calon] = nama_sukan

    // Mula transaksi untuk memastikan semua undian disimpan atau tiada langsung
    mysqli_begin_transaction($condb);

    try {
        // Pertama,semak jika pengguna sudah mengundisebelum ini
        $semak_undi = mysqli_query($condb, "SELECT * FROM undian WHERE nokp='$nokp'");
        if (mysqli_num_rows($semak_undi) > 0) {
            throw new Exception("Anda sudah mengundi sebelum ini.");
        }

        // Proses setiap undian
        foreach ($undi as $id_calon => $nama_sukan) {
            $id_calon = mysqli_real_escape_string($condb,$id_calon);
            $nama_sukan = mysqli_real_escape_string($condb, $nama_sukan);

            // Dapatkan idsukan berdasarkan nama sukan
            $sukan_query = mysqli_query($condb,"SELECT idsukan FROM sukan
                        WHERE nama_sukan='$nama_sukan'");

            if (!$sukan_query || mysqli_num_rows($sukan_query) == 0) {
                throw new Exception("Sukan tidak ditemukan.");
            }

            $sukan_data = mysqli_fetch_assoc($sukan_query);
            $idsukan = $sukan_data['idsukan'];

            // Simpan undian ke pangkalan data
            $insert_query = "INSERT INTO undian (nokp, id_calon, idsukan)
                            VALUES ('$nokp', '$id_calon', '$idsukan')";

            if (!mysqli_query($condb, $insert_query)) {
                throw new Exception("Gagal menyimpan undian: " . mysqli_error($condb));
            }
        }

        // Jika semua berjaya,commit transaksi
        mysqli_commit($condb);
        echo "<script>alert('Undian anda telah direkodkan.Terima kasih!');
                window.location='index.php';</script>";
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($condb);
        echo "<script>alert('Error:" . addslashes($e->getMessage()) . "');
                window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('Tiada data undian dihantar.');
            window.location='undi_kedudukan.php';</script>";
}
?>