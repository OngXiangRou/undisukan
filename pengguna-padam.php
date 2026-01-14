<?php
session_start();
include('kawalan-admin.php');

#menyemak kewujudan data get nokp ahli
if(!empty($_GET)) {
    #memanggil fail connectrion.php
    include('connection.php');

    #arahan sql untuk memadamkan ahli mengikut nokp yang dihantar
    $arahan = " delete from pengguna where nokp ='".$_GET['nokp']."'";

    #melaksanakan arahan sql padam data dan mengikut   menguji proses padam data
    if(mysqli_query($condb, $arahan)){
        #Jika data berjaya dipadam 
        echo"<script> alert('Padam data berjya');
        window.location.href = 'pengguna-senarai.php';</script>";
    }else{
        #Jika data gagal dipadam
        echo"<script> alert('Padam data gagal');
        window.location.href = 'pengguna-senarai.php';</script>";
    }
}else{
    #Jika data get tidak wujud 
    die("<script> alert('Ralat! Akses secara terus');
    window.location.href = 'pengguna-senarai.php';</script>");
}
    ?>