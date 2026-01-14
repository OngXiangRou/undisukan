<?php
#memulakan fungsi session
session_start();
#memangil fail header.php
include('header.php');
?>
<!-- Tajuk antara muka log masuk-->
<h3 style="margin-left: 15px;">Login Pengguna dan Admin</h3>

<!--borang daftar masuk (login/sign in)-->
  <form action="login-proses.php" method="POST">
    
        <div style="margin-left: 15px;">
            <div>nokp<br>
            <input placeholder="nokp:" class='nokp' type="text" name="nokp"><br></div>
            <div class="katalaluan-div">Katalaluan <br>
            <input placeholder="katalaluan:" type="password" name="katalaluan"><br>
                <input style="margin:0;" class="daftar-button" type="submit" value="login"></div>
        </div>


  </form>
  <?php include('footer.php'); ?>