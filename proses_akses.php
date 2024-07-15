<?php
// include "admin/koneksi.php";
// session_start();
// if (!isset($_SESSION['kodeakses'])) {
//     header("Location:login_akses.php");
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin/css/sweetalert.css">
    <script src="admin/js/jquery-2.1.4.min.js"></script>
    <script src="admin/js/sweetalert.min.js"></script>
    <link rel="icon" href="admin/logo/smkn_labuang.png">
</head>

<body>

</body>

</html>
<?php

include "admin/koneksi.php";
session_start();

$kodeakses = $_POST['kodeakses'];

$sql = mysqli_query($conn, "SELECT * FROM akses WHERE kodeakses='$kodeakses'");

$cek = mysqli_num_rows($sql);

if ($cek == 1) {
    while ($data = mysqli_fetch_array($sql)) {
        $_SESSION['kodeakses'] = $data['kodeakses'];
    }
    // echo '<script>alert("Proses login telah berhasil, selamat datang!"); window.location.href = "index.php"</script>';
    echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Akses Diterima',
	                text:  'Silahkan Masuk!',
	                type: 'success',
	                timer: 3000,
	                showConfirmButton: true
	            });   
	      });  
	      window.setTimeout(function(){ 
	        window.location.replace('index.php');
	      } ,900); 
	      </script>";
} else {
    // echo '<script>alert("Username atau password salah, silahkan coba lagi!"); window.location.href = "../login.php"</script>';
    echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Akses Ditolak',
	                text:  'Silahkan Coba Lagi!',
	                type: 'error',
	                timer: 3000,
	                showConfirmButton: true
	            });   
	      });  
	      window.setTimeout(function(){ 
	        window.location.replace('login_akses.php');
	      } ,900); 
	      </script>";
}
