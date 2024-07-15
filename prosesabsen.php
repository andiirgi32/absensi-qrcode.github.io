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

require 'admin/koneksi.php';

// Memeriksa apakah NIS dan tanggal tersedia dalam POST
if (isset($_POST["nis"], $_POST["tanggal"])) {

  $nis = $_POST["nis"];
  date_default_timezone_set('Asia/Makassar');
  $tanggal = $_POST["tanggal"];

  // Mendapatkan waktu saat ini dengan zona waktu Asia/Makassar
  $waktu = date("H:i:s");

  // Menentukan status absensi datang dan pulang
  $status_datang = '';
  $status_pulang = '';
  $is_datang = false;
  $is_pulang = false;

  if ($waktu >= '05:30:00' && $waktu <= '07:44:59') {
    $is_datang = true;
    if ($waktu >= '05:30:00' && $waktu <= '05:59:59') {
      $status_datang = 'Absen Cepat';
    } else if ($waktu >= '06:00:00' && $waktu <= '07:30:00') {
      $status_datang = 'Tepat Waktu';
    } else {
      $status_datang = 'Terlambat';
    }
  } else if ($waktu >= '07:45:00' && $waktu <= '15:59:59') {
    echo "<script type='text/javascript'>
              setTimeout(function () { 
                swal({
                        title: 'Maaf Waktu Untuk Melakukan Absensi Datang Sudah Lewat!',
                        text:  'Silahkan Lakukan Absensi Pulang Pada Pukul 16.00 WITA, Jangan Sampai Lewat Yah!',
                        type: 'warning',
                        timer: 5000,
                        showConfirmButton: false
                    });   
              });  
              window.setTimeout(function(){ 
                	        window.history.go(-1);
              } ,3000); 
              </script>";
    return false;
  } else if ($waktu >= '16:00:00' && $waktu <= '17:30:00') {
    $is_pulang = true;
    if ($waktu >= '16:00:00' && $waktu <= '16:30:00') {
      $status_pulang = 'Pulang Tepat Waktu';
    } else {
      $status_pulang = 'Pulang Terlambat';
    }
  } else {
    echo "<script type='text/javascript'>
              setTimeout(function () { 
                swal({
                        title: 'Maaf Waktu Untuk Melakukan Absensi Telah Selesai!',
                        text:  'Silahkan Lakukan Absensi Pada Besok Hari, Jangan Sampai Lewat Yah!',
                        type: 'error',
                        timer: 5000,
                        showConfirmButton: false
                    });   
              });  
              window.setTimeout(function(){ 
                	        window.history.go(-1);
              } ,3000); 
              </script>";
    return false;
  }

  // Memeriksa apakah NIS sudah ada dalam tabel siswa
  $check_nis_query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");

  if (mysqli_num_rows($check_nis_query) == 0) {
    echo "<script type='text/javascript'>
              setTimeout(function () { 
                swal({
                        title: 'NIS tidak terdaftar!',
                        text:  'Silakan hubungi admin',
                        type: 'error',
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

  // Memeriksa apakah NIS sudah ada dalam tabel absen untuk tanggal yang sama
  $check_absen_query = mysqli_query($conn, "SELECT * FROM absen WHERE nis='$nis' AND tanggal='$tanggal'");

  // Jika NIS sudah ada dalam tabel absen
  if (mysqli_num_rows($check_absen_query) == 1) {
    $absen_row = mysqli_fetch_assoc($check_absen_query);

    // Update absen pulang
    if ($is_pulang) {
      if ($absen_row['waktupulang'] != "00:00:00") {
        echo "<script type='text/javascript'>
                setTimeout(function () { 
                  swal({
                          title: 'Mohon Maaf Anda Sudah Absen Pulang!',
                          text:  'Silahkan Absen Pada Besok Hari',
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
      } else {
        $update_pulang_query = "UPDATE absen SET waktupulang='$waktu', keteranganpulang='$status_pulang' WHERE nis='$nis' AND tanggal='$tanggal'";
        $result = mysqli_query($conn, $update_pulang_query);

        $sql_nama = mysqli_query($conn, "SELECT nama FROM siswa WHERE nis='$nis'");
        $data_nama = mysqli_fetch_array($sql_nama);
        $nama = $data_nama['nama'];

        if ($result) {
          echo "<script type='text/javascript'>
                    setTimeout(function () { 
                      swal({
                              title: 'Selamat Anda Berhasil Absen Pulang, $nama!',
                              text:  'Silahkan Pulang',
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
          echo "Error: " . mysqli_error($conn);
        }
      }
    } else {
      echo "<script type='text/javascript'>
                setTimeout(function () { 
                  swal({
                          title: 'Mohon Maaf Anda Sudah Absen Datang!',
                          text:  'Silahkan Absen Pulang Pada Sore Hari',
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
  }

  // Jika NIS belum ada dalam tabel absen, lakukan pendaftaran absen
  else {
    if ($is_datang) {
      $result = mysqli_query($conn, "INSERT INTO absen (nis, tanggal, waktudatang, keterangandatang) VALUES ('$nis', '$tanggal', '$waktu', '$status_datang')");

      $sql_nama = mysqli_query($conn, "SELECT nama FROM siswa WHERE nis='$nis'");
      $data_nama = mysqli_fetch_array($sql_nama);
      $nama = $data_nama['nama'];

      if ($result) {
        echo "<script type='text/javascript'>
                    setTimeout(function () { 
                      swal({
                              title: 'Selamat Anda Berhasil Absen Datang, $nama!',
                              text:  'Silahkan Masuk',
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
        echo "Error: " . mysqli_error($conn);
      }
    } else if ($is_pulang) {
      $result = mysqli_query($conn, "INSERT INTO absen (nis, tanggal, waktupulang, keteranganpulang) VALUES ('$nis', '$tanggal', '$waktu', '$status_pulang')");
      // echo "<script type='text/javascript'>
      //           setTimeout(function () { 
      //             swal({
      //                     title: 'Mohon Maaf Anda Belum Absen Datang!',
      //                     text:  'Silahkan Absen Datang Terlebih Dahulu',
      //                     type: 'warning',
      //                     timer: 3000,
      //                     showConfirmButton: true
      //                 });   
      //           });  
      //           window.setTimeout(function(){ 
      //             	        window.history.go(-1);
      // window.location.replace('index.php');
      //           } ,900); 
      //           </script>";
      $sql_nama = mysqli_query($conn, "SELECT nama FROM siswa WHERE nis='$nis'");
      $data_nama = mysqli_fetch_array($sql_nama);
      $nama = $data_nama['nama'];
      echo "<script type='text/javascript'>
                    setTimeout(function () { 
                      swal({
                              title: 'Selamat Anda Berhasil Absen Pulang, $nama!',
                              text:  'Silahkan Pulang',
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
  }
} else {
  echo "Data NIS dan tanggal tidak tersedia dalam permintaan.";
}

?>