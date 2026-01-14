<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

// Proses form jika data dihantar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_sukan = mysqli_real_escape_string($condb, $_POST['nama_sukan']);

    // Generate ID Sukan (contoh: K1, K2, ...)
    $result = mysqli_query($condb,"SELECT MAX(idsukan) as max_id FROM sukan");
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];
    $next_id = 'K1'; // Default jika tiada rekod

    if ($max_id) {
        $num = (int)substr($max_id, 1) +1;
        $next_id = 'K' . $num;
    }

    // Masukkan data ke pangkalan data
    $sql = "INSERT INTO sukan(idsukan,nama_sukan)
            VALUES ('$next_id', '$nama_sukan')";
    
    if (mysqli_query($condb, $sql)) {
        echo "<script>alert('Sukan berjaya didaftarkan!');</script>";
    } else {
        echo "<script>alert('Ralat: " . mysqli_error($condb) ."');</script>";
    }
}

// Dapatkan senarai sukan sedia ada
$sukan = mysqli_query($condb,"SELECT * FROM sukan ORDER BY idsukan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Sukan</title>
</head>
<body>
    <h2> BORANG DAFTAR SUKAN</h2>

    <form method="POST" action="">
        <table border="1">
            <tr>
                <td>Nama sukan:</td>
                <td><input type="text" name="nama_sukan" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><button
                    type="submit">Daftar Sukan</button></td>
            </tr>
        </table>
    </form>

    <h3>Senarai Sukan Sedia ada</h3>
    <table border="1" width="100%">
        <tr>
            <th>ID Sukan</th>
            <th>Nama Sukan</th>
            <th>Tindakan</th>
        </tr>
        <?php
        if (mysqli_num_rows($sukan) > 0) {
            while ($row = mysqli_fetch_assoc($sukan)) {
                echo"<tr>";
                echo "<td>" . $row['idsukan'] . "</td>";
                echo "<td>" . $row['nama_sukan'] . "</td>";
                echo "<td>";
                echo "<a href='sukan-kemaskini.php?id=" . $row['idsukan'] . "'>
                                Kemaskini</a> | ";
                echo "<a href='sukan-padam.php?id=" . $row['idsukan'] . "'
                              onclick='return confirm(\"Anda pasti?\")'>Padam</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Tiada sukan didaftarkan</td></tr>";
        }
         ?>
    </table>
</body>
</html>