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
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$alamat = $_POST['alamat'];
$role = $_POST['role'];
$hakakses = $_POST['hakakses'];
$kelasid = $_POST['kelasid'];
$jurusanid = $_POST['jurusanid'];

$rand = rand();
$ekstensi = array("png", "jpg", "jpeg", "gif");
$namafile = $_FILES['fotouser']['name'];
$ukuran = $_FILES['fotouser']['size'];
$ext = pathinfo($namafile, PATHINFO_EXTENSION);

if (!in_array($ext, $ekstensi)) {
	echo "<script type='text/javascript'>
    setTimeout(function () { 
      swal({
              title: 'Data Gagal Diubah',
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
} else {
	if ($ukuran < 204488000) {
		$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
		if (mysqli_fetch_array($sql)) {
			echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Username Telah Terdaftar',
	                text:  'Silahkan Cari Username Yang Lain!',
	                type: 'warning',
	                timer: 3000,
	                showConfirmButton: true
	            });   
	      });  
	      window.setTimeout(function(){ 
	        window.history.go(-1);
	      } ,900); 
	      </script>";
			return false;
		}

		$xx = $rand . '_' . $namafile;
		move_uploaded_file($_FILES['fotouser']['tmp_name'], 'fotouser/' . $rand . '_' . $namafile);
		mysqli_query($conn, "INSERT INTO user VALUES('','$username','$password','$email','$namalengkap','$alamat','$xx','$role', '$hakakses','$kelasid','$jurusanid')");
		echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Data Berhasil Diubah',
	                text:  'Data Segera Ditampilkan!',
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
	                title: 'Ukuran Gambar Terlalu Besar',
	                text:  'Silahkan Cari Gambar Lain Atau Perkecil Size Gambar!',
	                type: 'warning',
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