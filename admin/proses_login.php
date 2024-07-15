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

$username = $_POST['username'];
$password = $_POST['password'];

$sql = mysqli_query($conn, "SELECT * FROM user WHERE (username='$username' OR email='$username') AND password='$password'");

$cek = mysqli_num_rows($sql);

if ($cek == 1) {
	while ($data = mysqli_fetch_array($sql)) {
		$_SESSION['userid'] = $data['userid'];
		$_SESSION['namalengkap'] = $data['namalengkap'];
		$_SESSION['fotouser'] = $data['fotouser'];
		$_SESSION['role'] = $data['role'];
		$_SESSION['hakakses'] = $data['hakakses'];
		$_SESSION['kelasid'] = $data['kelasid'];
		$_SESSION['jurusanid'] = $data['jurusanid'];
	}
	// echo '<script>alert("Proses login telah berhasil, selamat datang!"); window.location.href = "index.php"</script>';
	$namalengkap = $_SESSION['namalengkap'];
	echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Proses Login Telah Berhasil',
	                text:  'Selamat Datang, $namalengkap!',
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
	                title: 'Username Atau Password Salah',
	                text:  'Silahkan Coba Lagi!',
	                type: 'error',
	                timer: 3000,
	                showConfirmButton: true
	            });   
	      });  
	      window.setTimeout(function(){ 
	        window.location.replace('../login.php');
	      } ,900); 
	      </script>";
}
