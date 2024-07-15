<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
    <link rel="stylesheet" href="admin/css/sweetalert.css">
    <script src="admin/js/jquery-2.1.4.min.js"></script>
    <script src="admin/js/sweetalert.min.js"></script>
    <link rel="icon" href="admin/logo/smkn_labuang.png">
</head>

<body>
    <?php
    include "admin/koneksi.php";
    session_start();

    // Check if namalengkap is set in session
    if (isset($_SESSION['namalengkap'])) {
        $namalengkap = $_SESSION['namalengkap'];
        echo "<script type='text/javascript'>
            setTimeout(function () { 
                swal({
                        title: 'Proses Logout Telah Berhasil',
                        text:  'Sampai Jumpa, $namalengkap!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                    });   
            }, 100); // Adjusted timeout to 100ms as setTimeout doesn't work with 0ms
            window.setTimeout(function(){ 
                window.location.replace('login.php');
            } ,900); 
            </script>";
        // session_destroy();
        unset($_SESSION['userid']);
        unset($_SESSION['namalengkap']);
        unset($_SESSION['fotouser']);
        unset($_SESSION['role']);
        unset($_SESSION['hakakses']);
        unset($_SESSION['kelasid']);
        unset($_SESSION['jurusanid']);
    } else {
        echo "<script type='text/javascript'>
            setTimeout(function () { 
                swal({
                        title: 'Proses Logout Telah Berhasil',
                        text:  'Sampai Jumpa!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                    });   
            }, 100); // Adjusted timeout to 100ms as setTimeout doesn't work with 0ms
            window.setTimeout(function(){ 
                window.location.replace('login.php');
            } ,900); 
            </script>";
        // session_destroy();
        unset($_SESSION['userid']);
        unset($_SESSION['namalengkap']);
        unset($_SESSION['fotouser']);
        unset($_SESSION['role']);
        unset($_SESSION['hakakses']);
        unset($_SESSION['kelasid']);
        unset($_SESSION['jurusanid']);
    }
    ?>
</body>

</html>