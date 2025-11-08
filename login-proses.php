<?php
session_start();
#menyemak kewujudan data yang diisi dalam login-borang.php
if(!empty($_POST['nokp']) and !empty($_POST['katalaluan'])){
    include('connection.php');

    #mengambil data yang di post dari fail borang
    $nokp = $_POST['nokp'];
    $katalaluan = $_POST['katalaluan'];

    #arahan sql(query) untuk membandingkan data yang dimasukkan
    #wujud dalam pangkalan data atau tidak
    $query_login = "select* from pengguna
    where
        nokp = '$nokp'
    and katalaluan = '$katalaluan' LIMIT 1";

    #melaksanakan arahan membandingkan data
    $laksana_query = mysqli_query($condb,$query_login);

    #jika terdapat 1 data yang sepadan, login berjaya
    if(mysqli_num_rows($laksana_query) == 1){
        #mengambil data yang ditemui
        $m = mysqli_fetch_array($laksana_query);

        #mengumpul kepada pembolehubah session
        $_SESSION['nokp'] = $m['nokp'];
        $_SESSION['tahap'] = $m['tahap'];
        $_SESSION['nama'] = $m['nama'];

        #membuka laman undi_kedudukan.php
        echo"<script>window.location.href = 'index.php';</script>";
    }else{
        #login gagal,kembali ke laman login-borang.php
        die("<script> alert('login gagal');
        window.location.href = 'login-borang.php';</script>");
   }
}else{
    #data yang dihantar dari laman login-borang.php kosong
    die("<script> alert('sila masukkan nokp dan katalaluan');
    window.location.href = 'login-borang.php';</script>");
}
?>