
<h1> SISTEM PENGUNDIAN Kelab Olahraga SMK Tunku Abdul Rahman</h1>
<!--Skrin responsive-->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<hr>
<?php if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "ADMIN") { ?>
<nav>
     <a href='index.php'>Laman Utama</a>
     <a href='calon-senarai.php'>Senarai Calon </a>
     <a href='pengguna-senarai.php'>Senarai Pengguna</a>
     <a href='sukan-daftar.php'>Senarai Sukan</a>
     <a href='keputusan.php'>Keputusan</a>
     <a href='logout.php'>Logout</a>
 </nav>
 <hr>
<?php } else if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "PENGGUNA") { ?>
    <nav>
        <a href='index.php'>Laman Utama</a>
        <a href='undi_kedudukan.php'>Borang Pengundian</a>
        <a href='logout.php'>Logout</a>
    </nav>
    <hr>
<?php } else { ?>
    <nav>
        <a href='index.php'>Laman Utama</a>

    </nav>
    <hr>
<?php } ?>