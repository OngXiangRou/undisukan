<?php
// Memulakan fungsi session
session_start();

// Memanggil fail header.php dan sambungan database
include("header.php");
include("connection.php");
include("kawalan-admin.php");

// Fungsi untuk padam semua undian
if (isset($_POST['padam_semua'])) {
    $sql_padam = "DELETE FROM undian";
    if (mysqli_query($condb, $sql_padam)) {
        echo "<script>alert('Semua undian telah dipadam!');
        window.location.href='keputusan.php';</script>";
    } else {
        echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
    }
}

// Query untuk pemenang keseluruhan
$query_pemenang = "
    SELECT c.id_calon, c.nama_calon, c.gambar,
    COUNT(u.id_undi) as jumlah_undian
    FROM undian u
    JOIN calon c ON u.id_calon = c.id_calon
    GROUP BY c.id_calon, c.nama_calon, c.gambar
    ORDER BY jumlah_undian DESC
    LIMIT 1
";
$result_pemenang = mysqli_query($condb, $query_pemenang);
$pemenang_keseluruhan = mysqli_fetch_assoc($result_pemenang);

// Query untuk pemenang setiap sukan
$query_sukan = "
    SELECT j.idsukan, j.nama_sukan,
            c.id_calon, c.nama_calon, c.gambar,
            COUNT(u.id_undi) as jumlah_undian
    FROM undian u
    JOIN sukan j ON u.idsukan = j.idsukan
    JOIN calon c ON u.id_calon = c.id_calon
    GROUP BY j.idsukan,j.nama_sukan, c.id_calon, c.nama_calon, c.gambar
    ORDER BY j.nama_sukan, jumlah_undian DESC
";
$result_sukan = mysqli_query($condb,$query_sukan);

// Susun data pemenang mengikut sukan
$pemenang_sukan = [];
while ($row = mysqli_fetch_assoc($result_sukan)) {
    $sukan = $row['nama_sukan'];
    if(!isset($pemenang_sukan[$sukan]) || $row['jumlah_undian'] >
       $pemenang_sukan[$sukan]['jumlah_undian'])
       {$pemenang_sukan[$sukan] = $row;
    }
}
?>

<table width ="100%" border="1">
    <tr>
        <td colspan="2" align="center">
            <h2>KEPUTUSAN UNDIAN</h2>
        </td>
    </tr>

    <!-- Pemenang Keseluruhan -->
    <tr>
        <td colspan="2" bgcolor="#eeeeee">
            <h3>PEMENANG KESELURUHAN</h3>
            <?php if($pemenang_keseluruhan): ?>
                <table>
                    <tr>
                        <td>
                            <img src="<?= $pemenang_keseluruhan['gambar'] ?>"
                                 alt="<?= $pemenang_keseluruhan['nama_calon'] ?>"
                                 width="120" height="150">
                        </td>
                        <td>
                            <h3><?= $pemenang_keseluruhan['nama_calon'] ?></h3>
                            <p><b>Jumlah Undian:</b> <?= $pemenang_keseluruhan['jumlah_undian'] ?></p>
                        </td>
                    </tr>
                </table>
            <?php else:?>
                <p>Tiada data pemenang keseluruhan.</p>
                <?php endif; ?>
        </td>
    </tr>

    <!-- Pemenang Mengikut Sukan -->
    <tr>
        <td colspan="2">
            <h3>PEMENANG MENGIKUT SUKAN</h3>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" border="1" cellpadding="5">
            <?php foreach ($pemenang_sukan as $sukan => $pemenang): ?>
            <tr>
                <td width="30%" bgcolor="#eeeeee">
                    <h4>Sukan: <?= $sukan ?></h4>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <img src="<?= $pemenang['gambar'] ?>"
                                     alt="<?= $pemenang['nama_calon'] ?>"
                                     width="80" height="100">
                            </td>
                            <td>
                                <h4><?= $pemenang['nama_calon'] ?></h4>
                                <p><b>Undian:</b> <?= $pemenang['jumlah_undian'] ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php endforeach; ?>

            </table>
        </td>
    </tr>
</table>

<!-- Butang Padam Semua Undian (Hanya untuk Admin) -->
     <?php if ($_SESSION['tahap'] == 'ADMIN'): ?>
        <tr>
            <td colspan="2" align="right">
                <form method="POST" onsubmit="return confirm
                ('Adakah anda pasti ingin memadam SEMUA undian? Tindakan ini tidak boleh dipulihkan.');">
                <button type="submit" name="padam_semua" style="background-color: #f44336;
                color: white; padding: 8px 15px; border: none; cursor: pointer;">Padam Semua Undian
                </button>
                </form>

            </td>
        </tr>
    <!-- Butang Cetak Semua Undian -->
       <button onclick="window.print()" class="print-btn" style="background-color: #2b07f7ff;
               color: white; padding: 8px 40px; border: none; cursor: pointer;">Cetak Laporan</button>
       <?php endif; ?>


<?php include("footer.php"); ?>