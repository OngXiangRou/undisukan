<?php
# Menyemak nilai pembolehubah session['tahap']
if(!empty($_SESSION['tahap'])) {
    if($_SESSION['tahap'] != 'PENGGUNA')
    {
        # jika nilainya tidak sama dengan PENGGUNA,aturcara akan dihentikan
        die("<script>alert('Sila login');
        window.location.href='logout.php';</script>");
    }
} else {
    #jika nilai session empty
    die("<script>alert('Sila login');
    window.location.href='logout.php';</script>");
}
?>