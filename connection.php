<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

#nama host.localhost merupakan default
$nama_host="localhost";

#username bagi SQL.root merupakan default
$nama_sql="root";

#password bagi SQL.masukkan password anda.
$pass_sql="";

#nama pangkalan data yang anda telah bagunkan sebelum ini.
$nama_db="undi_sukan";

#membuka hubungan antara pangkalan data dan sistem.
$condb = mysqli_connect($nama_host, $nama_sql, $pass_sql, $nama_db);

#menguji antara hubungan berjaya dibuka
if (!$condb)
{
    die("Sambungan ke pangkalan data gagal");
}
else
{
    #echo "sambungan ke pangkalan data berjaya"
}
?>