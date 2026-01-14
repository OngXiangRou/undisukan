<?php
# Memulakan sesi
session_start();

# Memanggil fail header,connection dan kawalan admin
include('header.php');
include('connection.php');
include('kawalan-admin.php');

# Pastikan connection berjaya
if (!isset($condb)) {
    die("Kesalahan sambungan ke pangkalan data.");
}
?>

<h2 align='center'>Senarai Pengguna</h2>

<table align='center' width='70%' border='1' id='saiz'>
<tr bgcolor='pink'>
<td colspan='3'>
    <form action='' method='POST' style='margin:0; padding:0'>
        <input type='text' name='nama' placeholder='Carian Nama Pengguna'>
        <input type='submit' value='Cari'>
    </form>
</td>
<td colspan='3' align='right'>
    <a href='upload.php'>Muat Naik Pengguna</a>
    <?php include('butang-saiz.php');?>
</td>
</tr>
<tr bgcolor=' #FC9483'>
    <td width='10%'>Nama</td>
    <td width='10%'>No Kad Pengenalan</td>
    <td width='10%'>Katalaluan</td>
    <td width='10%'>Tahap</td>
    <td width='10%'>Tindakan</td>
</tr>

<?php
# Syarat tambahan untuk carian
$tambahan = "";
if (!empty($_POST['nama'])) {
    $nama = mysqli_real_escape_string($condb,$_POST['nama']);
    $tambahan = "WHERE pengguna.nama LIKE '%$nama%'";
}

# Arahan SQL untuk mendapatkan seanrai pengguna
$arahan_papar = "SELECT * FROM pengguna $tambahan";
$laksana = mysqli_query($condb, $arahan_papar);

# Paparkan data dalam jadual \
while ($m = mysqli_fetch_array($laksana)) {
    echo "<tr>
        <td>" . htmlspecialchars($m['nama']) . "</td>
        <td>" . htmlspecialchars($m['nokp']) . "</td>
        <td>" . htmlspecialchars($m['katalaluan']) . "</td>
        <td>" . htmlspecialchars($m['tahap']) . "</td>
        <td>
            <a href='pengguna-padam.php?nokp=" . urlencode($m['nokp']) . "'
               onclick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">
               Hapus
            </a>
        </td>
    </tr>";        
}
?>
</table>

<?php include('footer.php'); ?>