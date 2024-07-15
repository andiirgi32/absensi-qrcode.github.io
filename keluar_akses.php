<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Keluar ...</title>
    <link rel="stylesheet" href="admin/css/sweetalert.css">
    <script src="admin/js/jquery-2.1.4.min.js"></script>
    <script src="admin/js/sweetalert.min.js"></script>
    <link rel="icon" href="admin/logo/smkn_labuang.png">
</head>

<body>
    <?php
    include "admin/koneksi.php";
    session_start();

    echo "<script type='text/javascript'>
            setTimeout(function () { 
                swal({
                        title: 'Akses Keluar Diterima!',
                        text:  'Apk Akan Segera Dikunci!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                    });   
            }, 100); // Adjusted timeout to 100ms as setTimeout doesn't work with 0ms
            window.setTimeout(function(){ 
                window.location.replace('login_akses.php');
            } ,900); 
            </script>";
    // session_destroy();
    unset($_SESSION['kodeakses']);
    ?>
</body>

</html>