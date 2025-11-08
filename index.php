<?php
session_start();

include("header.php");
include("connection.php");

//Query undian mengikut sukan dengan ORDER BY idsukan
$query_sukan = "
SELECT
    j.idsukan,
    j.nama_sukan,
    c.id_calon,
    c.nama_calon,
    c.gambar,
    COUNT(u.id_undi) AS jumlah_undian
FROM undian u
JOIN sukan j ON u.sukan = j.idsukan
JOIN calon c ON u.idcalon = c.idcalon
GROUP BY j.idsukan, j.nama_sukan,c.idcalon,c.nama_calon,c.gambar
ORDER BY j.idsukan, jumlah_undian DESC"; // Perubahan di sini - ORDER BY idsukan dahulu

$result_sukan = mysqli_query($condb, $query_sukan);

if (!$result_sukan) {
    die("SQL Error: " . mysqli_error($condb));
}

//Susun data undian mengikut idsukan
$undian_sukan = [];
while ($row = mysqli_fetch_assoc($result_sukan)) {
    $idsukan =$row['idsukan'];
    if (!isset($undian_sukan[$idsukan])) {
        $undian_sukan[$idsukan] = [
            'nama_sukan' => $row['nama_sukan'],
            'calon' => []
        ];
    }
    $undian_sukan[$idsukan]['calon'][] = $row;
}

//Urutkan array berdasarkan idsukan (jika perlu)
ksort($undian_sukan);
?>

<table width="100%">
    <tr>
        <td width="70%" bgcolor="#D8C4B8" align="center">
            <img src="banner.jpg" style="width:50%; max-width:400px;">
        </td>
        <td align ="center" bgcolor="#D8C4B8">
            <h3>Daftar Sebagai Pengundi</h3>
            <h3>Klik Pautan Dibawah</h3>
            <a href="login-borang.php">Log Masuk</a><br>
            <a href="signup.php">Daftar Pengguna Baharu</a>
        </td>
    </tr> 
</table>

<!-- Paparan Undian Mengikut Sukan -->
 <div style="padding: 20px; background-color: #f5f5f5;margin-top: 20px">
    <h2 style="text-align: center;color:#2c3e50;">UNDIAN SEMASA MENGIKUT SUKAN</h2>

    <?php foreach ($undian_sukan as $idsukan => $data_sukan): ?>
        <div style="margin-bottom: 30px; background-color: white; padding: 15px;
        border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3 style="color: #31708f; border-bottom: 2px solid #D8C4B8; padding-bottom: 5px;">
                <?= $data_sukan['nama_sukan'] ?>
            </h3>
    
            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px;">
                <?php foreach ($data_sukan['calon'] as $undian): ?>
                    <div style="flex: 1; min-width: 200px; background-color: #f9f9f9;
                    padding: 10px; border-radius: 5px; border-left: 4px solid #D8C4B8;">
                    <div style="display: flex; align-items: center;">
                        <img src="<?= $undian['gambar'] ?>"
                             alt="<?= $undian['nama_calon'] ?>"
                             style="width: 60px; height: 75px; object-fit: cover;
                                    border-radius: 5px; margin-right: 10px;">
                        <div>
                            <h4 style="margin: 0;"><?= $undian['nama_calon'] ?></h4>
                            <p style="margin: 5px 0;color: #e74c3c; font-weight: bold;">
                                Undian: <?= $undian['jumlah_undian'] ?>
                            </p>    
                        </div>
                   </div>
              </div>
              <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
 </div>

 <?php include ("footer.php"); ?>