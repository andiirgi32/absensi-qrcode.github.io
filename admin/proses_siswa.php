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

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelasid = $_POST['kelasid'];
$jurusanid = $_POST['jurusanid'];
$jk = $_POST['jk'];

$rand = rand();
$ekstensi = array("png", "jpg", "jpeg", "gif");
$namafile = $_FILES['fotosiswa']['name'];
$ukuran = $_FILES['fotosiswa']['size'];
$ext = pathinfo($namafile, PATHINFO_EXTENSION);

if (!in_array($ext, $ekstensi)) {
	echo "<script type='text/javascript'>
    setTimeout(function () { 
      swal({
              title: 'Data Gagal Ditambahkan',
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
		$sql = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
		if (mysqli_fetch_array($sql)) {
			echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'NIS Telah Terdaftar',
	                text:  'Silahkan Cari NIS Yang Lain!',
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
		move_uploaded_file($_FILES['fotosiswa']['tmp_name'], 'fotosiswa/' . $rand . '_' . $namafile);
		mysqli_query($conn, "INSERT INTO siswa VALUES('','$nis','$nama','$xx','$kelasid','$jurusanid','$jk')");
		echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Data Berhasil Ditambahkan',
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