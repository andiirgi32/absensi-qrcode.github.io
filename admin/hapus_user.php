<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/sweetalert.css">
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <link rel="icon" href="logo/smkn_labuang.png">
</head>

<body>

</body>

</html>

<?php

include "koneksi.php";
session_start();

$userid = $_GET['userid'];

$sql = mysqli_query($conn, "SELECT fotouser, role FROM user where userid='$userid'");
$data = mysqli_fetch_array($sql);
$fotouser = $data['fotouser'];
$userrole = $data['role'];

if ($userrole == "Admin") {
  echo "<script type='text/javascript'>
        setTimeout(function () { 
          swal({
                  title: 'Data Gagal Dihapus',
                  text:  'Proses Hapus Dibatalkan karena user ini adalah Admin!',
                  type: 'error',
                  timer: 3000,
                  showConfirmButton: true
              });   
        });  
        window.setTimeout(function(){ 
          window.history.go(-1);
      } ,900); 
        </script>";
} else {
  unlink("fotouser/$fotouser");

  mysqli_query($conn, "DELETE FROM user WHERE userid='$userid'");

  if ($sql) {
    echo "<script type='text/javascript'>
              setTimeout(function () { 
                swal({
                        title: 'Akun Ini Berhasil Dihapus Permanent',
                        text:  'Data Ini Akan Segera Hilang!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                    });   
              });  
              window.setTimeout(function(){ 
                window.history.go(-1);
              } ,900); 
              </script>";
  } else {
    echo "<script type='text/javascript'>
    setTimeout(function () { 
      swal({
              title: 'Akun Ini Gagal Dihapus Permanent',
              text:  'Silahkan Coba Lagi!',
              type: 'error',
              timer: 3000,
              showConfirmButton: true
          });   
    });  
    window.setTimeout(function(){ 
      window.history.go(-1);
    } ,900); 
    </script>";
  }
}
?>