<?php
# Memulakan sesi
session_start();
error_reporting(0);

# Memnggil ail header.php,connection.php, dan <kawalan-admin.php
include('header.php');
include('connection.php');
include('kawalan-admin.php');

?>
<h3 align='center'>Senarai Calon</h3>

<!-- Header bagi jadual untuk memaparkan senarai calon-->
 <table align='center' width='70%' border='1' id='saiz'>
    <tr bgcolor=#FFCBC4>
        <td colspan='2' align='right'>
            <form action='' method='POST' style="margin:0; padding:0;">
                <input type='text' name='nama_calon' placeholder='Carian calon'>
                <input type='submit' value='Cari'>
            </form>
        </td>
        <td colspan='5' align='right'>
              <a href=calon-daftar.php>Daftar Calon Baru</a>
            <!-- Memanggil fail butang-saiz bagi membolehkan pengguna mengubah saiz tulisan -->
             <?php include('butang-saiz.php'); ?>
        </td>
    </tr>
    <tr bgcolor=#FC9483 align='center'>
        <td>ID Calon</td>
        <td>Nama Calon</td>
        <td>Gambar</td>
        <td>Tindakan</td>
    </tr>

<?php

# Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai calon
$tambahan ="";
if(!empty($_POST['nama_calon'])) {
    $tambahan = "WHERE nama_calon LIKE'%".$_POST['nama_calon']."%'";
}

# Arahan query untuk mencari calon
$arahan_papar = "SELECT * FROM calon $tambahan";

# Laksanakan arahan mencari data calon
$laksana = mysqli_query($condb, $arahan_papar);

# Mengambil data yang ditemui
while($row= mysqli_fetch_array($laksana)) {
    # Memaparkan senarai calon dalam jadual
    echo "<tr>
        <td>{$row['id_calon']}</td>
        <td>{$row['nama_calon']}</td>
        <td class='gambar-cell'><img src='{$row['gambar']}' alt='{$row['nama_calon']}'
            style=max-width: 100px; height: auto; '></td>
        <td align='right'>
        
              <a href='calon-padam.php?id_calon=".$row['id_calon']."'
                onClick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">Hapus</a>
              <a href='calon-kemaskini-borang.php?id_calon=".$row['id_calon']."'>Kemaskini</a>

        </td>
    </tr>";
}

?>
</table>
<?php include('footer.php'); ?>