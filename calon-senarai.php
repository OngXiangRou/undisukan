<?php
# Memulakan sesi
session_starrt();
error_reporting(0);

# Memnggil ail header.php,connection.php, dan <kawalan-admin.php
include('header.php');
include('connection.php');
include('kawalan-admin.php');

?>
<h3 align='center'>Senarai Calon</h3>

<!-- Header bagi jadual untuk memaparkan senarai calon-->
 <table align='center' width='70%' border='1' id='saiz'>