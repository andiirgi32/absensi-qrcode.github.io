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

$userid = $_POST['userid'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$alamat = $_POST['alamat'];
$role = $_POST['role'];
$hakakses = $_POST['hakakses'];
$kelasid = $_POST['kelasid'];
$jurusanid = $_POST['jurusanid'];

if ($_FILES['fotouser']['name'] != "") {
  $rand = rand();
  $ekstensi = array("png", "jpeg", "jpg", "gif");
  $namafile = $_FILES['fotouser']['name'];
  $ukuran = $_FILES['fotouser']['size'];
  $ext = pathinfo($namafile, PATHINFO_EXTENSION);

  if (!in_array($ext, $ekstensi)) {
    // echo '<script>alert("Data gagal diubah!"); window.location.href = "index.php"</script>';
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
    if ($ukuran < 20488000) {
      $sql = mysqli_query($conn, "SELECT fotouser FROM user where userid='$userid'");
      $data = mysqli_fetch_array($sql);
      $fotouser = $data['fotouser'];
      unlink("fotouser/$fotouser");

      $xx = $rand . '_' . $namafile;
      move_uploaded_file($_FILES['fotouser']['tmp_name'], 'fotouser/' . $rand . '_' . $namafile);
      mysqli_query($conn, "UPDATE user SET username='$username', password='$password', fotouser='$xx', email='$email', namalengkap='$namalengkap', alamat='$alamat', role='$role', hakakses='$hakakses', kelasid='$kelasid', jurusanid='$jurusanid' WHERE userid='$userid'");
      // echo '<script>alert("Data berhasil diubah, harap login ulang!"); window.location.href = "index.php"</script>';

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
} else {
  mysqli_query($conn, "UPDATE user SET username='$username', password='$password', email='$email', namalengkap='$namalengkap', alamat='$alamat', role='$role', hakakses='$hakakses', kelasid='$kelasid', jurusanid='$jurusanid' WHERE userid='$userid'");
  // echo '<script>alert("Data berhasil diubah, harap login ulang!"); window.location.href = "index.php"</script>';
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
}

// $sql = mysqli_query($conn, "UPDATE album SET namaalbum='$namaalbum', deskripsi='$deskripsi' WHERE albumid='$albumid'");

// if($sql) {
//     echo '<script>alert("Data berhasil diubah!"); window.location.href = "album.php"</script>';
// } else {
//     echo '<script>alert("Data gagal diubah!"); window.location.href = "album.php"</script>';
// }

?>