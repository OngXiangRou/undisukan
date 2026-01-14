<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

$id = $_GET['id'] ?? '';

// Dapatkan data sukan
$result = mysqli_query($condb,"SELECT * FROM sukan WHERE idsukan = '$id'");
$sukan = mysqli_fetch_assoc($result);

// Proses form jika data dihantar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_sukan = mysqli_real_escape_string($condb, $_POST['id_sukan']);
    $nama_sukan = mysqli_real_escape_string($condb, $_POST['nama_sukan']);

    // Semak jika ID baru sudah wujud (kecuali jika sama dengan ID asal)
    if ($id_sukan != $id){
        $check_sql = "SELECT idsukan FROM sukan WHERE idsukan = '$id_sukan'";
        $check_result = mysqli_query($condb, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            echo
            "<script>alert('Ralat: Id Sukan \"$id_sukan\" sudah wujud dalam sistem!');</script>";

        } else {
            // Kemaskini kedua-dua ID dan nama jika ID baru unik
            $sql = "UPDATE sukan SET idsukan = '$id_sukan', nama_sukan = '$nama_sukan'
            WHERE idsukan = '$id'";

            if (mysqli_query($condb, $sql)) {
                echo "<script>alert('Sukan berjaya dikemaskini!');
                window.location.href='sukan-daftar.php';</script>";
            } else {
                echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
            }
        }
    } else {
        // Jika ID tidak berubah,hanya kemaskini nama sukan
        $sql = "UPDATE sukan SET nama_sukan = '$nama_idsukan' WHERE idsukan = '$id'";

        if (mysqli_query($condb, $sql)) {
            echo "<script>alert('Sukan berjaya dikemaskini!');
            window.location.href='sukan-daftar.php';</script>";
        } else {
            echo "<script>alert('Ralat:" . mysqli_error($condb) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kemaskini Sukan</title>
</head>
<body>
    <h2>KEMASKINI SUKAN</h2>

    <form method="POST" action="">
        <table border="1">
            <tr>
                <td>ID Sukan:</td>
                <td><input type="text" name="id_sukan"
                        value="<?php echo $sukan['idsukan']; ?>" required></td>
            </tr>
            <tr>
                 <td>Nama Sukan:</td>
                 <td><input type="text" name="nama_sukan"
                        value="<?php echo $sukan['nama_sukan']; ?>" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit">Kemaskini</button>
                    <a href="sukan-daftar.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>