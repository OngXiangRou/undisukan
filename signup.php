<?php

# Memanggil fail header.php
include('header.php');
include('connection.php');
// Jika borang dihantar
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $nokp = $_POST['nokp'];
    $nama = $_POST['nama'];
    $katalaluan = $_POST['katalaluan'];

    $katalaluan_hash = password_hash($katalaluan,PASSWORD_DEFAULT);

    //Semak jika No KP telah wujud
    $semak = $condb->query("SELECT * FROM PENGGUNA WHERE nokp='$nokp'");
    if ($semak->num_rows > 0) {
        echo"<p style='color:red;'>No KP telah didaftarkan.</p>";
    } else {
        $sql = "INSERT INTO PENGGUNA (nokp, nama, katalaluan, tahap)
                VALUES ('$nokp', '$nama', '$katalaluan_hash', 'PENGGUNA')";
        
        if ($condb->query($sql) === TRUE) {
            echo "<script>alert('Pendaftaran Berjaya. Sila Log Masuk');
                    window.location.href='login-borang.php';
                  </script>";
        } else {
            echo "<p style='color:red;'>Ralat: " . $condb->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Pengguna</title>
</head>
<body>
    <h2>Borang Daftar Pengguna</h2>
    <form method="POST">
      <label>No KP:</label><br>
      <input type="text" name="nokp" placeholder="cth:123456789012" pattern="[0-9]{12}"
              oninvalid="this.setCustomValidity('Sila masukkan 12 digit nombor sahaja')"
              oninput="this.setCustomValidity('')" required><br><br>
            
      <label>Name:</label>
      <input type="text" name="nama" required><br><br>
    
      <label>Katalaluan:</label><br>
      <input type="password" name="katalaluan" required><br><br>
    
    
      <input type="submit" value="Daftar">
    </form>
</body>  
</html>