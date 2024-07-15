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

$kodeakses = $_POST['kodeakses'];

$rand = rand();
$ekstensi = array("png", "jpg", "jpeg", "gif");
$namafile = $_FILES['qrcode']['name'];
$ukuran = $_FILES['qrcode']['size'];
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
    }, 100);  
    window.setTimeout(function(){ 
            window.history.go(-1);
    } ,900); 
    </script>";
} else {
    if ($ukuran < 204488000) {
        $sql = mysqli_query($conn, "SELECT * FROM akses WHERE kodeakses='$kodeakses'");
        if (mysqli_fetch_array($sql)) {
            echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Kode Akses Telah Terdaftar',
	                text:  'Silahkan Pilih Kode Akses Lain!',
	                type: 'warning',
	                timer: 3000,
	                showConfirmButton: true
	            });   
	      }, 100);  
	      window.setTimeout(function(){ 
            window.history.go(-1);
	      } ,900); 
	      </script>";
        } else {
            $xx = $rand . '_' . $namafile;
            move_uploaded_file($_FILES['qrcode']['tmp_name'], 'qraksesmasuk/' . $rand . '_' . $namafile);
            mysqli_query($conn, "INSERT INTO akses (kodeakses, qrcode) VALUES ('$kodeakses', '$xx')");
            echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Data Berhasil Ditambahkan',
	                text:  'Data Akan Segera Ditampilkan!',
	                type: 'success',
	                timer: 3000,
	                showConfirmButton: true
	            });   
	      }, 100);  
	      window.setTimeout(function(){ 
            window.history.go(-1);
	      } ,900); 
	      </script>";
        }
    } else {
        echo "<script type='text/javascript'>
	      setTimeout(function () { 
	        swal({
	                title: 'Ukuran Gambar Terlalu Besar',
	                text:  'Silahkan Pilih Gambar Lain atau Perkecil Ukuran Gambar!',
	                type: 'warning',
	                timer: 3000,
	                showConfirmButton: true
	            });   
	      }, 100);  
	      window.setTimeout(function(){ 
            window.history.go(-1);
	      } ,900); 
	      </script>";
    }
}
?>