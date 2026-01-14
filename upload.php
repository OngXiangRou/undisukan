<?php
# memulakan fungsi session
session_start();

# memangil fail header, kawala-admin
include('header.php');
include('kawalan-admin.php');
?>

<!-- Tajuk laman -->
 <h3>Muat Naik Data Pengguna (*.txt)</h3>

 <!-- Borang untuk memuat naik naik fail -->
  <form action='' method="POST" enctype='multipart/form-data'>

    <h3><b>Sila Pilih Fail txt yang ingin diupload</b></h3>
    <input     type='file'    name='data_admin'>
    <button    type='submit'  name='btn-upload'>Muat Naik</button>  
  
</form>
<?php include ('footer.php'); ?>

<!-- Bahagian Memproses Data yang dimuat naik -->
<?PHP
# data validation : menyemak kewujudan data dari borang
if (isset($_POST['btn-upload']))
{
  # memanggil fail connection
  include ('connection.php');

  # memanggil nama sementara fail
  $namafailementara=$_FILES["data_admin"]["tmp_name"];

  # memanggil nama fail
  $namafail=$_FILES['data_admin']['name'];

  # mengambil jenis fail
  $jenisfail=pathinfo($namafail, PATHINFO_EXTENSION);
  
  # menguji jenis fail dan saiz fail
  if($_FILES["data_admin"]["size"]>0 AND $jenisfail=="txt")
  {
     # membuka fail yang mengambil
     $fail_data_admin=fopen($namafailsementara,"r");
     $success = true;
     $total_data = 0;
     $data_berjaya = 0;

    # mendapatkan data dari fail baris demi baris
    while (!feof($fail_data_admin))
    {
      # mengambil data sebaris sahaja bg setiap pusingan
      $ambilbarisdata = trim(fgets($fail_data_admin));

      if(empty($ambilbarisdata)) continue;

      $total_data++;

      # memecahkan baris data mengikut tanda pipe
      $pecahkanbaris = explode("|", $ambilbarisdata);

      #pastikan ada cukup data
      if(count($pecahkanbaris) < 4) {
        $success = false;
        continue;
      }

      # selepas pecahan tadi akan diumpukan kepada 4
      list($nama, $nokp, $katalaluan, $tahap) = $pecahkanbaris;

      # bersihkan data
      $nama = trim($nama);
      $nokp = trim($nokp);
      $katalaluan = trim($katalaluan);
      $tahap = trim($tahap);

      # arahan SQL untuk menyimpan data
      $arahan_sql_simpan = "INSERT INTO pengguna
      (nama, nokp, katalaluan, tahap) VALUES
      ('$nama', '$nokp', '$katalaluan', '$tahap')";

      # memasukkan data kedalam jadual pengguna
      $laksana_arahan_simpan=mysqli_query($condb, $arahan_sql_simpan);

      if($laksana_arahan_simpan){
        $data_berjaya++;
      } else {
        $success = false;
      }
    }
    # menutup fail txt yang dibuka
    fclose($fail_data_admin); 
    
    if($success) {
      echo "<script>alert('$total_data rekod berjaya diimport.');
      window.location.href='pengguna-senarai.php';
      </script>";
    } else {
      echo "<script>alert('Import gagal.Sila semak format fail.');
      window.location.href='pengguna-senarai.php';
      </script>";
    }
  }
  else
  {
    # jika fail yang dimuat naik kosong atau tersalah format.
    echo "<script>alert('Hanya fail berformat txt sahaja dibenarkan');</script>";
  }
}
?>