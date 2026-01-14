<?php
session_start();
include('kawalan-admin.php');
include('connection.php');

//Dapatkan data calon
$id_calon = $_GET['id_calon'];
$result = mysqli_query($condb,"SELECT *FROM calon WHERE id_calon='$id_calon'");
$calon = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
        <title>Kemaskini Calon</title>
</head>
<body>
    <h2>Kemaskini Calon</h2>
    
    <form action="calon-kemaskini-proses.php" method="POST">
       <input type="hidden" name="id_calon" value="<?= $calon['id_calon'] ?>">

       Nama Calon:
       <input type="text" name="nama_calon" value="<?= $calon ['nama_calon'] ?>"
              required><br><br>

        Gambar Semasa:
        <?php if (!empty($calon['gambar'])): ?>
            <img src="<?= $calon['gambar'] ?>" alt="Gambar Calon" width="100"><br>
        <?php else: ?>
            <p>Tiada gambar</p>
        <?php endif; ?>
        <br>

        <input type="submit" value="Kemaskini">
        <a href="calon-senarai.php">Batal</a>
        </form>
</body>
</html>