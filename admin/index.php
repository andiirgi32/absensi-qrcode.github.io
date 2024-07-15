<?php
include "koneksi.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
  header("Location:login.php");
} else if (!isset($_SESSION['kodeakses'])) {
  header("Location:../login_akses.php");
}

// Check for theme in session or cookies
if (isset($_SESSION['theme'])) {
  $theme = $_SESSION['theme'];
} elseif (isset($_COOKIE['theme'])) {
  $theme = $_COOKIE['theme'];
  $_SESSION['theme'] = $theme;
} else {
  $theme = 'default';
}
?>

<?php
if ($_SESSION['role'] != "Admin" && $_SESSION['role'] != "Kepala Sekolah" && $_SESSION['role'] != "Wali Kelas") {
  header("Location:../index.php");
  exit();
}

date_default_timezone_set('Asia/Makassar');
$TanggalHariIni = date("Y-m-d");

$get_sql_total_pelajar_smkn_labuang = mysqli_query($conn, "SELECT * FROM siswa");
$get_data_total_pelajar_smkn_labuang = mysqli_num_rows($get_sql_total_pelajar_smkn_labuang);

$get_sql_total_pelajar_laki2_smkn_labuang = mysqli_query($conn, "SELECT * FROM siswa WHERE jk='Laki-Laki'");
$get_data_total_pelajar_laki2_smkn_labuang = mysqli_num_rows($get_sql_total_pelajar_laki2_smkn_labuang);

$get_sql_total_pelajar_perempuan_smkn_labuang = mysqli_query($conn, "SELECT * FROM siswa WHERE jk='Perempuan'");
$get_data_total_pelajar_perempuan_smkn_labuang = mysqli_num_rows($get_sql_total_pelajar_perempuan_smkn_labuang);

$get_sql_semua_pelajar_absen_hari_ini = mysqli_query($conn, "SELECT * FROM absen WHERE tanggal='$TanggalHariIni'");
$get_data_semua_pelajar_absen_hari_ini = mysqli_num_rows($get_sql_semua_pelajar_absen_hari_ini);

$get_data_total_pelajar_tidak_absen_hari_ini = $get_data_total_pelajar_smkn_labuang - $get_data_semua_pelajar_absen_hari_ini;

$get_sql_pelajar_absen_datang_dan_absen_pulang_hari_ini = mysqli_query($conn, "SELECT * FROM absen WHERE tanggal='$TanggalHariIni' AND waktudatang != '00:00:00' AND waktupulang != '00:00:00'");
$get_data_pelajar_absen_datang_dan_absen_pulang_hari_ini = mysqli_num_rows($get_sql_pelajar_absen_datang_dan_absen_pulang_hari_ini);

$get_sql_pelajar_absen_datang_hari_ini = mysqli_query($conn, "SELECT * FROM absen WHERE tanggal='$TanggalHariIni' AND waktudatang != '00:00:00' AND waktupulang='00:00:00'");
$get_data_pelajar_absen_datang_hari_ini = mysqli_num_rows($get_sql_pelajar_absen_datang_hari_ini);

$get_sql_pelajar_absen_pulang_hari_ini = mysqli_query($conn, "SELECT * FROM absen WHERE tanggal='$TanggalHariIni' AND waktudatang = '00:00:00' AND waktupulang != '00:00:00'");
$get_data_pelajar_absen_pulang_hari_ini = mysqli_num_rows($get_sql_pelajar_absen_pulang_hari_ini);

$get_sql_semua_user = mysqli_query($conn, "SELECT * FROM user");
$get_data_semua_user = mysqli_num_rows($get_sql_semua_user);

$get_sql_semua_jurusan = mysqli_query($conn, "SELECT * FROM jurusan");
$get_data_semua_jurusan = mysqli_num_rows($get_sql_semua_jurusan);

$get_sql_semua_kelas = mysqli_query($conn, "SELECT * FROM kelas");
$get_data_semua_kelas = mysqli_num_rows($get_sql_semua_kelas);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="logo/smkn_labuang.png" rel="icon">
  <title>Ruang<?= $_SESSION['role'] ?> - Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
  <!-- <link rel="stylesheet" href="css/iconbootstrap.css"> -->
  <link rel="stylesheet" href="css/node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/node_modules/bootstrap-icons/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="css/sweetalert.css">
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <script src="js/Chart.js"></script>


  <?php if ($theme == 'default') : ?>
    <link rel="stylesheet" href="theme/default.css">
  <?php elseif ($theme == 'theme1') : ?>
    <link rel="stylesheet" href="theme/theme1.css">
  <?php elseif ($theme == 'theme2') : ?>
    <link rel="stylesheet" href="theme/theme2.css">
  <?php elseif ($theme == 'theme3') : ?>
    <link rel="stylesheet" href="theme/theme3.css">
  <?php elseif ($theme == 'theme4') : ?>
    <link rel="stylesheet" href="theme/theme4.css">
  <?php elseif ($theme == 'theme5') : ?>
    <link rel="stylesheet" href="theme/theme5.css">
  <?php endif; ?>

  <style>
    .berita-user-profile {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      position: relative;
      left: 50%;
      transform: translateX(-50%);
    }

    .berita-user-profile-utama {
      width: 125px;
      height: 125px;
      border-radius: 50%;
      object-fit: cover;
      /* position: relative;
            left: 50%;
            transform: translateX(-50%); */
    }

    .berita-user-profile-nav {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .space-between-body {
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      min-height: 100vh;
    }

    .navbar-fixed {
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1;
    }

    .container-margin {
      margin-top: 100px;
    }

    .space-between-card {
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      min-height: 100%;
    }

    .container-grid {
      display: grid;
      grid-template-areas: 'tentang-akun' 'semua-post';
    }

    .tentang-akun {
      grid-area: tentang-akun;
    }

    .semua-post {
      grid-area: semua-post;
    }

    /* =============================================================== */
    a {
      text-decoration: none;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top">

  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
    </symbol>
  </svg>

  <div class="dropdown position-fixed bottom-0 star-0 mb-3 ml-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#sun-fill"></use>
          </svg>
          Light
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#moon-stars-fill"></use>
          </svg>
          Dark
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#circle-half"></use>
          </svg>
          Auto
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
    </ul>
  </div>

  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light bg-body-tertiary accordion" id="accordionSidebar">
      <a class="sidebar-brand bg-sidebar-theme d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="logo/smkn_labuang.png" style="border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-2">SMKN Labuang</div>
      </a>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Modal Pop Up
      </div>
      <li class="nav-item">
        <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#cetakHarian">
          <i class="fas fa-fw fa-print"></i>
          <span>Cetak</span></a>
      </li>
      <?php
      if ($_SESSION['role'] == "Admin") {
      ?>
        <li class="nav-item">
          <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#buatQRCode">
            <i class="fas fa-fw fa-qrcode"></i>
            <span>Buat QR Code</span></a>
        </li>
      <?php
      }
      ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Halaman
      </div>
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../index.php">
          <i class="fas fa-fw fa-qrcode"></i>
          <span>E-Absensi</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Daftar Absensi
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTableAbsensiPelajar" aria-expanded="true" aria-controls="collapseTable">
          <i class="fas fa-fw fa-address-card"></i>
          <span>Card</span>
        </a>
        <div id="collapseTableAbsensiPelajar" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="card py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pelajar</h6>
            <a class="collapse-item" href="absensi_harian.php">
              Absensi Harian
            </a>
            <a class="collapse-item" href="absensi_bulanan.php">
              Absensi Bulanan
            </a>
          </div>
        </div>
      </li>
      <?php
      if ($_SESSION['role'] == "Admin") {
      ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Features 001
        </div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
          </a>
          <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="card py-2 collapse-inner rounded">
              <h6 class="collapse-header">Tables</h6>
              <a class="collapse-item" href="table_kelas.php">Table Kelas</a>
              <a class="collapse-item" href="table_jurusan.php">Table Jurusan</a>
              <a class="collapse-item" href="table_pelajar.php">Table Pelajar</a>
              <a class="collapse-item" href="table_aksesmasuk.php">Table Akses</a>
              <a class="collapse-item" href="table_user.php">Table User</a>
            </div>
          </div>
        </li>
      <?php
      }
      ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features 002
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTablePelajar" aria-expanded="true" aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables Pelajar</span>
        </a>
        <div id="collapseTablePelajar" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="card py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tables</h6>
            <?php
            if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Kepala Sekolah") {
              $sql_kelas = mysqli_query($conn, "SELECT * FROM kelas");
              while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
            ?>
                <a class="collapse-item" href="data_siswa_kelas.php?kelasid=<?= $data_kelas['kelasid'] ?>&namakelas=<?= $data_kelas['namakelas'] ?>&jurusanid=<?= $data_kelas['jurusanid'] ?>">Table <?= $data_kelas['namakelas'] ?></a>
              <?php
              }
            } else if ($_SESSION['role'] == "Wali Kelas") {
              $kelasid = $_SESSION['kelasid'];
              $sql_kelas = mysqli_query($conn, "SELECT * FROM kelas WHERE kelasid='$kelasid'");
              while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
              ?>
                <a class="collapse-item" href="data_siswa_kelas.php?kelasid=<?= $data_kelas['kelasid'] ?>&namakelas=<?= $data_kelas['namakelas'] ?>&jurusanid=<?= $data_kelas['jurusanid'] ?>">Table <?= $data_kelas['namakelas'] ?></a>
            <?php
              }
            }
            ?>
          </div>
        </div>
      </li>
      <!-- <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin"></div> -->
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column bg-body-tertiary">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <div class="nav-link dropdown-toggle">
                <i class="fas fa-user-tie fa-fw text-user"></i>&nbsp;
                <div class="text-user"><?= $_SESSION['role'] ?></div>
              </div>
            </li>
            <!-- <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-warning badge-counter">2</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/man.png" style="max-width: 60px" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been
                      having.</div>
                    <div class="small text-gray-500">Udin Cilok · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/girl.png" style="max-width: 60px" alt="">
                    <div class="status-indicator bg-default"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people
                      say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Jaenab · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
                <span class="badge badge-success badge-counter">3</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Task
                </h6>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Design Button
                      <div class="small float-right"><b>50%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Make Beautiful Transitions
                      <div class="small float-right"><b>30%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Create Pie Chart
                      <div class="small float-right"><b>75%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
              </div>
            </li> -->
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="fotouser/<?= $_SESSION['fotouser'] ?>" style="max-width: 60px; object-fit: cover;">
                <span class="ml-2 d-none d-lg-inline text-user small"><?= $_SESSION['namalengkap'] ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#myProfile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#setting">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal" id="buttonModalLogout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid bg-body-tertiary" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <?php
          if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Kepala Sekolah") {
          ?>
            <div class="container-fluid">

              <div class="row">

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Absensi Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_semua_pelajar_absen_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($_SESSION['role'] == 'Admin') { ?>absensi_harian.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: greenyellow;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Absen Datang & Absen Pulang Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_pelajar_absen_datang_dan_absen_pulang_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: green;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Hanya Absen Datang Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_pelajar_absen_datang_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: yellow;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Hanya Absen Pulang Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_pelajar_absen_pulang_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: orange;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Tidak Absensi Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_total_pelajar_tidak_absen_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: red;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Semua Pelajar Perempuan SMKN Labuang</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_total_pelajar_perempuan_smkn_labuang ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: pink;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Semua Pelajar Laki-Laki SMKN Labuang</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_total_pelajar_laki2_smkn_labuang ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x text-primary"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Semua Pelajar SMKN Labuang</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_total_pelajar_smkn_labuang ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-users fa-3x" style="color: gray;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">User</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_semua_user ?> Akun</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user fa-3x" style="color: blue;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Tanggal & Waktu</div>
                          <div class="h6 mb-0 font-weight-bold text-gray-700">
                            <?php
                            $sqlPointsLAndP = "SELECT k.namakelas, COALESCE(SUM(CASE WHEN s.jk = 'Laki-Laki' THEN 1 ELSE 0 END), 0) AS jumlah_laki, COALESCE(SUM(CASE WHEN s.jk = 'Perempuan' THEN 1 ELSE 0 END), 0) AS jumlah_perempuan FROM kelas k LEFT JOIN siswa s ON k.kelasid = s.kelasid GROUP BY k.namakelas";

                            $result = $conn->query($sqlPointsLAndP);

                            // Array untuk menyimpan hasil query
                            $dataPointsL = array();
                            $dataPointsP = array();

                            if ($result->num_rows > 0) {
                              while ($rowPointsLAndP = $result->fetch_assoc()) {
                                $dataPointsL[] = array("label" => $rowPointsLAndP['namakelas'], "y" => (int)$rowPointsLAndP['jumlah_laki']);
                                $dataPointsP[] = array("label" => $rowPointsLAndP['namakelas'], "y" => (int)$rowPointsLAndP['jumlah_perempuan']);
                              }
                            }

                            // Tutup koneksi database
                            // $conn->close();
                            ?>
                            <script src="js/canvasjs.min.js"></script>
                            <script>
                              function displayTime() {
                                var clientTime = new Date();
                                var time = new Date(clientTime.getTime());
                                var sh = time.getHours().toString();
                                var sm = time.getMinutes().toString();
                                var ss = time.getSeconds().toString();
                                document.getElementById("jam").innerHTML = (sh.length == 1 ? "0" + sh : sh) + " : " + (sm.length == 1 ? "0" + sm : sm) + " : " + (ss.length == 1 ? "0" + ss : ss);
                                document.getElementById("jaminput").value = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" + sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
                              }

                              window.onload = function() {
                                displayTime(); // Display time immediately when page loads
                                setInterval(displayTime, 1000); // Update time every second

                                var chart = new CanvasJS.Chart("chartContainer", {
                                  exportEnabled: true,
                                  animationEnabled: true,
                                  title: {
                                    text: "Total Peserta Laki-Laki dan Perempuan per Kelas"
                                  },
                                  axisX: {
                                    title: "Kelas"
                                  },
                                  axisY: {
                                    title: "Jumlah Peserta",
                                    includeZero: true
                                  },
                                  toolTip: {
                                    shared: true
                                  },
                                  legend: {
                                    cursor: "pointer",
                                    itemclick: toggleDataSeries
                                  },
                                  data: [{
                                      type: "column",
                                      name: "Laki-Laki",
                                      showInLegend: true,
                                      yValueFormatString: "#,##0.# Orang",
                                      dataPoints: <?php echo json_encode($dataPointsL, JSON_NUMERIC_CHECK); ?>
                                    },
                                    {
                                      type: "column",
                                      name: "Perempuan",
                                      showInLegend: true,
                                      yValueFormatString: "#,##0.# Orang",
                                      dataPoints: <?php echo json_encode($dataPointsP, JSON_NUMERIC_CHECK); ?>
                                    }
                                  ]
                                });

                                chart.render();

                                function toggleDataSeries(e) {
                                  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                    e.dataSeries.visible = false;
                                  } else {
                                    e.dataSeries.visible = true;
                                  }
                                  e.chart.render();
                                }
                              };
                            </script>
                            <?php
                            function getDayIndonesia($date)
                            {
                              if ($date != '0000-00-00') {
                                $data = hari(date('D', strtotime($date)));
                              } else {
                                $data = '-';
                              }

                              return $data;
                            }

                            function hari($day)
                            {
                              $hari = $day;

                              switch ($hari) {
                                case "Sun":
                                  $hari = "Minggu";
                                  break;
                                case "Mon":
                                  $hari = "Senin";
                                  break;
                                case "Tue":
                                  $hari = "Selasa";
                                  break;
                                case "Wed":
                                  $hari = "Rabu";
                                  break;
                                case "Thu":
                                  $hari = "Kamis";
                                  break;
                                case "Fri":
                                  $hari = "Jum'at";
                                  break;
                                case "Sat":
                                  $hari = "Sabtu";
                                  break;
                              }
                              return $hari;
                            }

                            // Menampilkan nama hari format Bahasa Indonesia
                            $hari_ini = date('Y-m-d');
                            echo getDayIndonesia($hari_ini);
                            echo date(" d/m/Y");
                            ?><br>
                            <font id="jam"></font> WITA
                            <input type="text" id="jaminput" name="" style="display: none;">
                          </div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-clock fa-3x" style="color: purple;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Jurusan</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_semua_jurusan ?> Jurusan</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <!-- <i class="fas fa-user fa-3x" style="color: blue;"></i> -->
                          <i class="bi bi-easel2-fill fa-3x" style="color: violet;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Kelas</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_semua_kelas ?> Kelas</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="bi bi-lightbulb-fill fa-3x" style="color: skyblue;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-10 col-sm-11 col-12 mb-4">
                  <div class="card" style="height: 100%;">
                    <font class="text-secondary fw-bold">&nbsp;Grafik Polar Area Dari Jumlah Seluruh Peserta SMKN Labuang</font>
                    <canvas id="kelasChart" width="100" height="100"></canvas>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-10 col-sm-11 col-12 mb-4">
                  <div class="card" style="height: 100%;">
                    <font class="text-secondary fw-bold">&nbsp;Grafik Pie Dari Card Informasi Absensi Peserta SMKN Labuang Hari Ini</font>
                    <canvas id="kehadiranChart" width="100" height="100"></canvas>
                  </div>
                </div>
                <div class="col-12 mb-5">
                  <style>
                    a.canvasjs-chart-credit {
                      display: none;
                    }
                  </style>
                  <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                </div>
              </div>

            </div>
          <?php
          } else if ($_SESSION['role'] == "Wali Kelas") {
          ?>
            <div class="container-fluid">

              <div class="row">

                <?php
                $sql_semua_pelajar_absen_hari_ini = mysqli_query($conn, "SELECT absen.*, siswa.nama, siswa.kelasid FROM absen JOIN siswa ON absen.nis = siswa.nis WHERE siswa.kelasid = '$kelasid' AND absen.tanggal='$TanggalHariIni'");
                $wali_data_semua_pelajar_absen_hari_ini = mysqli_num_rows($sql_semua_pelajar_absen_hari_ini);

                $kelasid = $_SESSION['kelasid'];
                $sql_kelas_wali = mysqli_query($conn, "SELECT * FROM kelas WHERE kelasid='$kelasid'");

                $jurusanid = $_SESSION['jurusanid'];
                $sql_jurusan_wali = mysqli_query($conn, "SELECT * FROM jurusan WHERE jurusanid='$jurusanid'");

                $namakelas = '';
                $namajurusan = '';
                // Periksa apakah query mengembalikan hasil
                if (mysqli_num_rows($sql_kelas_wali) == 0) {
                  // Jika tidak ada hasil, tampilkan pesan error
                  // echo "<p style='color: red;'>Error: kelasid tidak ditemukan dalam tabel kelas.</p>";
                ?>
                  <div class="row">
                    <div class="col-12">
                      <div class="alert alert-danger alert-dismissible h5" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h6><i class="fas fa-exclamation-triangle card bg-light text-danger" style="width: max-content; display: inline; padding: 2px;"></i> <b class="card bg-light text-danger" style="width: max-content; display: inline;">Kesalahan Program!&nbsp;</b></h6>
                        <div class="card bg-light text-danger" style="width: max-content; display: inline; line-height: 30px;">&nbsp;Error: kelasid tidak ditemukan dalam Tabel Kelas.&nbsp;</div><br>
                        <div class="card bg-light text-danger" style="width: max-content; display: inline; line-height: 30px;">&nbsp;Harap beritahu Admin untuk segera mengatasi masalah ini!&nbsp;</div>
                      </div>
                    </div>
                  </div>
                <?php
                } else {
                  $data_kelas_wali = mysqli_fetch_array($sql_kelas_wali);
                  $data_jurusan_wali = mysqli_fetch_array($sql_jurusan_wali);
                  $namakelas = $data_kelas_wali['namakelas'];
                  $namajurusan = $data_jurusan_wali['kepanjangan'];
                }

                // Periksa apakah query mengembalikan hasil
                if (mysqli_num_rows($sql_jurusan_wali) == 0) {
                  // Jika tidak ada hasil, tampilkan pesan error
                  // echo "<p style='color: red;'>Error: kelasid tidak ditemukan dalam tabel kelas.</p>";
                ?>
                  <div class="row">
                    <div class="col-12">
                      <div class="alert alert-danger alert-dismissible h5" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h6><i class="fas fa-exclamation-triangle card bg-light text-danger" style="width: max-content; display: inline; padding: 2px;"></i> <b class="card bg-light text-danger" style="width: max-content; display: inline;">Kesalahan Program!&nbsp;</b></h6>
                        <div class="card bg-light text-danger" style="width: max-content; display: inline; line-height: 30px;">&nbsp;Error: jurusanid tidak ditemukan dalam Tabel Jurusan.&nbsp;</div><br>
                        <div class="card bg-light text-danger" style="width: max-content; display: inline; line-height: 30px;">&nbsp;Harap beritahu Admin untuk segera mengatasi masalah ini!&nbsp;</div>
                      </div>
                    </div>
                  </div>
                <?php
                }
                $sql_total_pelajar = mysqli_query($conn, "SELECT * FROM siswa WHERE kelasid='$kelasid'");
                $data_total_pelajar = mysqli_num_rows($sql_total_pelajar);

                $data_pelajar_tidak_absen_hari_ini = $data_total_pelajar - $wali_data_semua_pelajar_absen_hari_ini;

                $sql_pelajar_datang_dan_pulang_hari_ini = mysqli_query($conn, "SELECT absen.*, siswa.* FROM absen JOIN siswa ON absen.nis = siswa.nis WHERE siswa.kelasid = '$kelasid' AND tanggal='$TanggalHariIni' AND waktudatang != '00:00:00' AND waktupulang != '00:00:00'");
                $data_pelajar_datang_dan_pulang_hari_ini = mysqli_num_rows($sql_pelajar_datang_dan_pulang_hari_ini);

                $sql_pelajar_absen_datang_dan_tak_absen_pulang_hari_ini = mysqli_query($conn, "SELECT absen.*, siswa.* FROM absen JOIN siswa ON absen.nis = siswa.nis WHERE siswa.kelasid = '$kelasid' AND tanggal='$TanggalHariIni' AND waktudatang != '00:00:00' AND waktupulang = '00:00:00'");
                $data_pelajar_absen_datang_dan_tak_absen_pulang_hari_ini = mysqli_num_rows($sql_pelajar_absen_datang_dan_tak_absen_pulang_hari_ini);

                $sql_pelajar_tak_absen_datang_dan_absen_pulang_hari_ini = mysqli_query($conn, "SELECT absen.*, siswa.* FROM absen JOIN siswa ON absen.nis = siswa.nis WHERE siswa.kelasid = '$kelasid' AND tanggal='$TanggalHariIni' AND waktudatang = '00:00:00' AND waktupulang != '00:00:00'");
                $data_pelajar_tak_absen_datang_dan_absen_pulang_hari_ini = mysqli_num_rows($sql_pelajar_tak_absen_datang_dan_absen_pulang_hari_ini);

                $sql_laki2_peserta_wali = mysqli_query($conn, "SELECT * FROM siswa WHERE kelasid='$kelasid' AND jk='Laki-Laki'");
                $data_laki2_peserta_wali = mysqli_num_rows($sql_laki2_peserta_wali);

                $sql_perempuan_peserta_wali = mysqli_query($conn, "SELECT * FROM siswa WHERE kelasid='$kelasid' AND jk='Perempuan'");
                $data_perempuan_peserta_wali = mysqli_num_rows($sql_perempuan_peserta_wali);
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar <?= $namakelas ?> Absensi Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $wali_data_semua_pelajar_absen_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($_SESSION['role'] == 'Admin') { ?>absensi_harian.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: greenyellow;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Absen Datang & Absen Pulang Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $data_pelajar_datang_dan_pulang_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: green;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Hanya Absen Datang Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $data_pelajar_absen_datang_dan_tak_absen_pulang_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: yellow;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Hanya Absen Pulang Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $data_pelajar_tak_absen_datang_dan_absen_pulang_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: orange;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Tidak Absensi Hari Ini</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $data_pelajar_tidak_absen_hari_ini ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: red;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pelajar Tidak Absen Datang & Absen Pulang Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $get_data_pelajar_tidak_absen_datang_hari_ini ?> Orang</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                          <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-user-tie fa-3x" style="color: red;"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Perempuan <?= $namakelas ?></div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $data_perempuan_peserta_wali ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x" style="color: pink;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pelajar Laki_laki <?= $namakelas ?></div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $data_laki2_peserta_wali ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user-tie fa-3x text-primary"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Total Semua Pelajar <?= $namakelas ?></div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $data_total_pelajar ?> Orang</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-users fa-3x" style="color: gray;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">User</div>
                          <div class="h6 mb-0 font-weight-bold text-gray-700"><?= $_SESSION['namalengkap'] ?><br>(<?= $_SESSION['role'] . ' ' . $namakelas ?>)</div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-user fa-3x" style="color: blue;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Tanggal & Waktu</div>
                          <div class="h6 mb-0 font-weight-bold text-gray-700">
                            <script type="text/javascript">
                              function displayTime() {
                                var clientTime = new Date();
                                var time = new Date(clientTime.getTime());
                                var sh = time.getHours().toString();
                                var sm = time.getMinutes().toString();
                                var ss = time.getSeconds().toString();
                                document.getElementById("jam").innerHTML = (sh.length == 1 ? "0" + sh : sh) + " : " + (sm.length == 1 ? "0" + sm : sm) + " : " + (ss.length == 1 ? "0" + ss : ss);
                                document.getElementById("jaminput").value = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" + sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
                              }

                              window.onload = function() {
                                displayTime(); // Display time immediately when page loads
                                setInterval(displayTime, 1000); // Update time every second
                              };
                            </script>
                            <?php
                            function getDayIndonesia($date)
                            {
                              if ($date != '0000-00-00') {
                                $data = hari(date('D', strtotime($date)));
                              } else {
                                $data = '-';
                              }

                              return $data;
                            }

                            function hari($day)
                            {
                              $hari = $day;

                              switch ($hari) {
                                case "Sun":
                                  $hari = "Minggu";
                                  break;
                                case "Mon":
                                  $hari = "Senin";
                                  break;
                                case "Tue":
                                  $hari = "Selasa";
                                  break;
                                case "Wed":
                                  $hari = "Rabu";
                                  break;
                                case "Thu":
                                  $hari = "Kamis";
                                  break;
                                case "Fri":
                                  $hari = "Jum'at";
                                  break;
                                case "Sat":
                                  $hari = "Sabtu";
                                  break;
                              }
                              return $hari;
                            }

                            // Menampilkan nama hari format Bahasa Indonesia
                            $hari_ini = date('Y-m-d');
                            echo getDayIndonesia($hari_ini);
                            echo date(" d/m/Y");
                            ?><br>
                            <font id="jam"></font> WITA
                            <input type="text" id="jaminput" name="" style="display: none;">
                          </div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-clock fa-3x" style="color: purple;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                $jurusanid = $_SESSION['jurusanid'];
                $sql_jurusan = mysqli_query($conn, "SELECT * FROM jurusan WHERE jurusanid='$jurusanid'");
                $data_jurusan = mysqli_fetch_array($sql_jurusan);
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Jurusan</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $namajurusan ?></div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <!-- <i class="fas fa-user fa-3x" style="color: blue;"></i> -->
                          <i class="bi bi-easel2-fill fa-3x" style="color: violet;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-uppercase mb-1">Kelas</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-700"><?= $namakelas ?></div>
                          <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- <span class="text-success mr-2"><a class="text-decoration-none" href="<?php if ($fetch['role'] == 'Admin' || $fetch['role'] == 'Kepala Sekolah') { ?>datatables_rpl.php<?php } ?>">Lihat Detail <i class="fas fa-arrow-right text-gray-700"></i></a></span> -->
                            <!-- <span>Since last month</span> -->
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="bi bi-lightbulb-fill fa-3x" style="color: skyblue;"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-10 col-sm-11 col-12 mb-4">
                  <div class="card" style="height: 100%;">
                    <font class="text-secondary fw-bold ml-1">Grafik Doughnut Dari Jumlah Laki-Laki & Perempuan Peserta UPTD SMKN Labuang</font>
                    <canvas id="jkPesertaWali" width="100" height="100"></canvas>
                  </div>

                  <script>
                    // Data dari PHP
                    const data_laki2_peserta_wali = <?php echo $data_laki2_peserta_wali; ?>;
                    const data_perempuan_peserta_wali = <?php echo $data_perempuan_peserta_wali; ?>;

                    // Membuat chart pie
                    const ctxWali = document.getElementById('jkPesertaWali').getContext('2d');
                    const jkPesertaWali = new Chart(ctxWali, {
                      type: 'doughnut',
                      data: {
                        labels: [
                          'Pelajar <?= $namakelas ?> Laki-Laki',
                          'Pelajar <?= $namakelas ?> Perempuan',
                        ],
                        datasets: [{
                          data: [
                            data_laki2_peserta_wali,
                            data_perempuan_peserta_wali,
                          ],
                          backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(201, 203, 207, 0.2)' // Warna tambahan
                          ],
                          borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(201, 203, 207, 1)' // Warna tambahan
                          ],
                          borderWidth: 1
                        }]
                      },
                      options: {
                        responsive: true,
                        plugins: {
                          legend: {
                            position: 'top',
                          },
                          title: {
                            display: true,
                            text: 'Kehadiran Siswa Hari Ini'
                          },
                          tooltip: {
                            callbacks: {
                              label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                if (label) {
                                  label += ': ';
                                }
                                label += value;
                                return label;
                              }
                            }
                          }
                        }
                      }
                    });
                  </script>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-10 col-sm-11 col-12 mb-4">
                  <div class="card" style="height: 100%;">
                    <font class="text-secondary fw-bold ml-1">Grafik Pie Dari Card Informasi Absensi <?= $namakelas ?> Hari Ini</font>
                    <canvas id="kehadiranChartWali" width="100" height="100"></canvas>
                  </div>

                  <script>
                    // Data dari PHP
                    const PelajarAbsenDatangDanAbsenPulangHariIni = <?php echo $data_pelajar_datang_dan_pulang_hari_ini; ?>;
                    const PelajarHanyaAbsenDatangHariIni = <?php echo $data_pelajar_absen_datang_dan_tak_absen_pulang_hari_ini; ?>;
                    const PelajarHanyaAbsenPulangHariIni = <?php echo $data_pelajar_tak_absen_datang_dan_absen_pulang_hari_ini; ?>;
                    const TotalPelajarTidakAbsensiHariIni = <?php echo $data_pelajar_tidak_absen_hari_ini; ?>;

                    // Membuat chart pie
                    const ctx2Wali = document.getElementById('kehadiranChartWali').getContext('2d');
                    const kehadiranChartWali = new Chart(ctx2Wali, {
                      type: 'pie',
                      data: {
                        labels: [
                          'Pelajar <?= $namakelas ?> Absen Datang & Absen Pulang Hari Ini',
                          'Pelajar <?= $namakelas ?> Hanya Absen Datang Hari Ini',
                          'Pelajar <?= $namakelas ?> Hanya Absen Pulang Hari Ini',
                          'Total <?= $namakelas ?> Pelajar Tidak Absensi Hari Ini',
                        ],
                        datasets: [{
                          data: [
                            PelajarAbsenDatangDanAbsenPulangHariIni,
                            PelajarHanyaAbsenDatangHariIni,
                            PelajarHanyaAbsenPulangHariIni,
                            TotalPelajarTidakAbsensiHariIni,
                          ],
                          backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(201, 203, 207, 0.2)' // Warna tambahan
                          ],
                          borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(201, 203, 207, 1)' // Warna tambahan
                          ],
                          borderWidth: 1
                        }]
                      },
                      options: {
                        responsive: true,
                        plugins: {
                          legend: {
                            position: 'top',
                          },
                          title: {
                            display: true,
                            text: 'Kehadiran Siswa Hari Ini'
                          },
                          tooltip: {
                            callbacks: {
                              label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                if (label) {
                                  label += ': ';
                                }
                                label += value;
                                return label;
                              }
                            }
                          }
                        }
                      }
                    });
                  </script>
                </div>
              </div>

            </div>
          <?php
          }
          ?>

          <!-- <style>
            .kelap-kelip {
              background: url('default/bintang.gif') repeat;
              position: absolute;
              width: 100%;
              height: 100%;
              opacity: 0.5;
              filter: blur(1px);
            }
          </style> -->
          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
            <!-- <div class="kelap-kelip" data-dismiss="modal" aria-label="Close"></div> -->
            <div class="modal-dialog" role="document">
              <form class="modal-content" action="../logout.php" method="post">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="margin: 0; padding: 0; display: flex; justify-content: center; align-items: center;">
                  <img src="default/Tak berjudul28_20240708190427.png" alt="" style="width: 90%;">
                </div>
                <div class="modal-footer" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                  <div class="h5 mb-3">Apa Jawaban Anda?</div>
                  <div style="display: flex; align-items: center;">
                    <button type="submit" class="btn btn-primary mr-2" id="logoutButton">I'm Sure</button>
                    <div class="h5 mx-2">Atau</div>
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Not Sure</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <script>
            $(document).ready(function() {
              $('#logoutModal').on('shown.bs.modal', function() {
                // $('#focusInput').trigger('focus');
                document.addEventListener('keydown', function(event) {
                  if (event.key === 'Enter') {
                    document.getElementById('logoutButton').click();
                  }
                }, {
                  once: true
                });
              });

              document.addEventListener('keydown', function(event) {
                if (event.key === 'Alt') {
                  document.addEventListener('keydown', function(event) {
                    if (event.key === '/') {
                      document.getElementById('buttonModalLogout').click();
                    }
                  }, {
                    once: true
                  });
                }
              });
            });
          </script>
          <!-- Akhir Modal Logout -->

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-navbar">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy;
              <?= date("Y") ?> i RPL UPTD SMK Negeri Labuang
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <?php
  if ($_SESSION['hakakses'] == "Dilarang") {
    echo "<script type='text/javascript'>
        setTimeout(function () { 
          swal({
                  title: 'Anda Dilarang Untuk Mengakses Halaman Ini',
                  text:  'Silahkan Hubungi Admin Utama Untuk Meminta Izin Akses!',
                  type: 'error',
                  timer: 5000,
                  showConfirmButton: false
              });   
        });  
        window.setTimeout(function(){ 
      window.location.replace('../index.php');
    } ,5000); 
        </script>";
  }
  ?>

  <!-- Modal Scrollable -->
  <div class="modal fade" id="cetakHarian" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form class="modal-content" action="hasil_print.php" method="post" target="_blank">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="bi bi-printer-fill"></i> Cetak (Masukan Data)</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <div class="modal-body">
          <label for="tanggal">tanggal</label>
          <input type="date" class="form-control mb-2" id="tanggal" name="tanggal" placeholder="klik dan ketik disini..." required value="<?= date("Y-m-d") ?>">
          <label for="kelasid">Kelas</label>
          <select name="kelasid" id="kelasid" class="form-control mb-2" required>
            <?php
            if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Kepala Sekolah") {
            ?>
              <option value="">Pilihan</option>
              <?php
            }
            if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Kepala Sekolah") {
              $sql_kelas = mysqli_query($conn, "SELECT * FROM kelas");
              while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
              ?>
                <option value="<?= $data_kelas['kelasid'] ?>"><?= $data_kelas['namakelas'] ?></option>
              <?php
              }
            } else if ($_SESSION['role'] == "Wali Kelas") {
              $kelasid = $_SESSION['kelasid'];
              $sql_kelas = mysqli_query($conn, "SELECT * FROM kelas WHERE kelasid='$kelasid'");
              while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
              ?>
                <option value="<?= $data_kelas['kelasid'] ?>"><?= $data_kelas['namakelas'] ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Tampikan" class="btn btn-success">
          <button type="reset" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <!-- Modal Scrollable -->
  <div class="modal fade" id="buatQRCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form id="qrcode-form" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Buat QR-Code</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <style>
          #qrcode {
            margin-top: 20px;
          }

          #qrcode canvas {
            width: 100%;
            /* Set the width you want here */
            max-width: 300px;
            /* Optional: set a max width */
            height: auto;
            /* Maintain the aspect ratio */
            /* margin: 0 auto; */
          }

          #qrcode-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
          }
        </style>
        <div class="modal-body">
          <div class="form-group">
            <label for="text">Kode Akses</label>
            <input class="form-control" type="text" id="text" placeholder="Enter text" required>
          </div>
          <div class="form-group">
            <label for="logo">Pilih Gambar Anda</label>
            <input class="form-control" type="file" id="logo" accept="image/*">
          </div>
          <div id="error-message" style="color: red; display: none;">Logo must be a square image (1:1 aspect ratio).</div>
          <div id="qrcode-container" style="display: none; text-align: center;">
            <div id="qrcode"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="download-btn" class="btn btn-warning" style="display:none;">Download QR Code</button>
          <button type="submit" class="btn btn-success">Generate QR Code</button>
          <button type="reset" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <!-- Modal Scrollable -->
  <div class="modal fade" id="myProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form class="modal-content" action="update_profile.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Profile Saya</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <div class="modal-body">
          <!-- <form action="update_user.php" method="post" enctype="multipart/form-data"> -->
          <?php
          $userid = $_SESSION['userid'];
          $sql = mysqli_query($conn, "SELECT * FROM user WHERE userid='$userid'");
          while ($data = mysqli_fetch_array($sql)) {
          ?>
            <input type="text" class="form-control mb-2" id="userid" name="userid" placeholder="klik dan ketik disini..." value="<?= $data['userid'] ?>" hidden>
            <label for="inputFoto" style="display: block;" class="mb-3">
              <img src="fotouser/<?= $data['fotouser'] ?>" alt="" class="berita-user-profile" id="imgFoto">
            </label>
            <input type="file" name="fotouser" id="inputFoto" class="form-control" hidden>
            <label for="username">Username</label>
            <input type="text" class="form-control mb-2" id="username" name="username" placeholder="klik dan ketik disini..." value="<?= $data['username'] ?>">
            <script>
              // Add event listener to the Username input field
              $('#username').on('input', function() {
                var username = $(this).val();
                // Convert to lowercase and remove spaces
                username = username.toLowerCase().replace(/\s+/g, '');
                $(this).val(username);
              });
            </script>
            <label for="password">Password</label>
            <input type="password" class="form-control mb-2" id="password" name="password" placeholder="klik dan ketik disini..." value="<?= $data['password'] ?>">
            <input type="checkbox" id="show-password"> <label for="show-password">Tampilkan Sandi</label>
            <label for="email" style="display: block;">Email</label>
            <input type="email" class="form-control mb-2" id="email" name="email" placeholder="klik dan ketik disini..." value="<?= $data['email'] ?>">
            <label for="namalengkap">Nama Lengkap</label>
            <input type="text" class="form-control mb-2" id="namalengkap" name="namalengkap" placeholder="klik dan ketik disini..." value="<?= $data['namalengkap'] ?>">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control mb-2" id="alamat" cols="30" rows="5" placeholder="klik dan ketik disini..."><?= $data['alamat'] ?></textarea>
            <input type="text" class="form-control mb-2" id="role" name="role" placeholder="klik dan ketik disini..." value="<?= $data['role'] ?>" hidden>
          <?php
          }
          ?>
          <!-- </form> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Ubah" class="btn btn-success">
          <button type="reset" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <!-- Modal Scrollable -->
  <div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form class="modal-content" action="change_theme.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="bi bi-gear-wide-connected"></i> Pengaturan</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="theme">Pilih Tema:</label>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="themeDefault" value="default" <?php if ($theme == 'default') echo 'checked'; ?>>
            <label class="form-check-label" for="themeDefault">
              <img src="theme/images/Tak berjudul20_20240608002134.png" alt="Default Tema" class="img-thumbnail" style="width: 50%;"> Default Tema
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme1" value="theme1" <?php if ($theme == 'theme1') echo 'checked'; ?>>
            <label class="form-check-label" for="theme1">
              <img src="theme/images/Tak berjudul20_20240608002241.png" alt="Biru & Biru Langit" class="img-thumbnail" style="width: 50%;"> Biru & Biru Langit
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme2" value="theme2" <?php if ($theme == 'theme2') echo 'checked'; ?>>
            <label class="form-check-label" for="theme2">
              <img src="theme/images/Tak berjudul20_20240608002352.png" alt="Orange & Kuning" class="img-thumbnail" style="width: 50%;"> Orange & Kuning
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme3" value="theme3" <?php if ($theme == 'theme3') echo 'checked'; ?>>
            <label class="form-check-label" for="theme3">
              <img src="theme/images/Tak berjudul20_20240608002447.png" alt="Hijau & Hijau Muda" class="img-thumbnail" style="width: 50%;"> Hijau & Hijau Muda
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme4" value="theme4" <?php if ($theme == 'theme4') echo 'checked'; ?>>
            <label class="form-check-label" for="theme4">
              <img src="theme/images/Tak berjudul20_20240608002529.png" alt="Merah & Merah Muda" class="img-thumbnail" style="width: 50%;"> Merah & Merah Muda
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme5" value="theme5" <?php if ($theme == 'theme5') echo 'checked'; ?>>
            <label class="form-check-label" for="theme5">
              <img src="theme/images/Tak berjudul20_20240608002628.png" alt="Ungu & Lavender" class="img-thumbnail" style="width: 50%;"> Ungu & Lavender
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-success" data-bs-dismiss="modal">Ubah Tema</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->
  <!-- <script src="js/demo/chart-area-demo.js"></script> -->
  <script src="js/ruang-admin.min.js"></script>

  <script src="js/image.js"></script>
  <script src="js/navbar.js"></script>
  <script src="js/bootstrap.js"></script>

  <script>
    document.getElementById('show-password').addEventListener('change', function() {
      var passwordInput = document.getElementById('password');
      if (this.checked) {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    });
  </script>

  <script>
    // Add event listener to the Username input field
    $('#username').on('input', function() {
      var username = $(this).val();
      // Convert to lowercase and remove spaces
      username = username.toLowerCase().replace(/\s+/g, '');
      $(this).val(username);
    });
  </script>

  <?php
  // Ambil data dari tabel dengan join
  $sql = "SELECT k.namakelas, COUNT(s.idsiswa) as count
FROM siswa s
JOIN kelas k ON s.kelasid = k.kelasid
GROUP BY k.namakelas
";
  $result = $conn->query($sql);

  $kelasData = [];
  $kelasLabels = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $kelasData[] = $row['count'];
      $kelasLabels[] = $row['namakelas'];
    }
  } else {
    echo "0 results";
  }
  $conn->close();
  ?>

  <script>
    // Siapkan data untuk Chart.js
    const kelasLabels = <?php echo json_encode($kelasLabels); ?>;
    const kelasData = <?php echo json_encode($kelasData); ?>;

    // Tampilkan diagram donat
    const ctx = document.getElementById('kelasChart').getContext('2d');
    const kelasChart = new Chart(ctx, {
      type: 'polarArea',
      data: {
        labels: kelasLabels,
        datasets: [{
          label: 'Jumlah Pelajar per Kelas',
          data: kelasData,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(199, 199, 199, 0.2)',
            'rgba(83, 102, 255, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)',
            'rgba(83, 102, 255, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Jumlah Pelajar per Kelas'
          }
        }
      }
    });
  </script>

  <script>
    // Data dari PHP
    const PelajarAbsenDatangDanAbsenPulangHariIni = <?php echo $get_data_pelajar_absen_datang_dan_absen_pulang_hari_ini; ?>;
    const PelajarHanyaAbsenDatangHariIni = <?php echo $get_data_pelajar_absen_datang_hari_ini; ?>;
    const PelajarHanyaAbsenPulangHariIni = <?php echo $get_data_pelajar_absen_pulang_hari_ini; ?>;
    const TotalPelajarTidakAbsensiHariIni = <?php echo $get_data_total_pelajar_tidak_absen_hari_ini; ?>;

    // Membuat chart pie
    const ctx2 = document.getElementById('kehadiranChart').getContext('2d');
    const kehadiranChart = new Chart(ctx2, {
      type: 'pie',
      data: {
        labels: [
          'Pelajar Absen Datang & Absen Pulang Hari Ini',
          'Pelajar Hanya Absen Datang Hari Ini',
          'Pelajar Hanya Absen Pulang Hari Ini',
          'Total Pelajar Tidak Absensi Hari Ini',
        ],
        datasets: [{
          data: [
            PelajarAbsenDatangDanAbsenPulangHariIni,
            PelajarHanyaAbsenDatangHariIni,
            PelajarHanyaAbsenPulangHariIni,
            TotalPelajarTidakAbsensiHariIni,
          ],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(201, 203, 207, 0.2)' // Warna tambahan
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(201, 203, 207, 1)' // Warna tambahan
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Kehadiran Siswa Hari Ini'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.label || '';
                let value = context.raw || 0;
                if (label) {
                  label += ': ';
                }
                label += value;
                return label;
              }
            }
          }
        }
      }
    });
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script>
    document.getElementById('qrcode-form').addEventListener('submit', function(e) {
      e.preventDefault();
      let qrcodeContainer = document.getElementById('qrcode');
      let qrcodeParentContainer = document.getElementById('qrcode-container');
      qrcodeContainer.innerHTML = "";
      qrcodeParentContainer.style.display = 'none';
      let text = document.getElementById('text').value;
      let logoInput = document.getElementById('logo');
      let errorMessage = document.getElementById('error-message');
      errorMessage.style.display = 'none';

      // Check if a logo is provided and if it's square
      if (logoInput.files && logoInput.files[0]) {
        let logo = new Image();
        logo.onload = function() {
          if (logo.width !== logo.height) {
            errorMessage.style.display = 'block';
            return;
          }
          generateQRCode(text, logo);
        };
        logo.src = URL.createObjectURL(logoInput.files[0]);
      } else {
        generateQRCode(text, null);
      }
    });

    function generateQRCode(text, logo) {
      let qrcodeContainer = document.getElementById('qrcode');
      let qrcodeParentContainer = document.getElementById('qrcode-container');
      let qrcode = new QRCode(qrcodeContainer, {
        text: text,
        width: 1024,
        height: 1024,
        correctLevel: QRCode.CorrectLevel.H
      });

      setTimeout(() => {
        let canvas = qrcodeContainer.getElementsByTagName('canvas')[0];
        let newCanvas = document.createElement('canvas');
        let padding = 100;
        newCanvas.width = canvas.width + padding * 2;
        newCanvas.height = canvas.height + padding * 2;
        let newContext = newCanvas.getContext("2d");
        newContext.fillStyle = "white";
        newContext.fillRect(0, 0, newCanvas.width, newCanvas.height);
        newContext.drawImage(canvas, padding, padding);

        if (logo) {
          let logoSize = 192; // Ukuran logo
          let x = (newCanvas.width / 2) - (logoSize / 2);
          let y = (newCanvas.height / 2) - (logoSize / 2);
          newContext.drawImage(logo, x, y, logoSize, logoSize);
        }

        qrcodeContainer.innerHTML = "";
        qrcodeContainer.appendChild(newCanvas);

        let downloadBtn = document.getElementById('download-btn');
        downloadBtn.style.display = 'block';
        downloadBtn.addEventListener('click', function() {
          let link = document.createElement('a');
          link.href = newCanvas.toDataURL("image/png");
          link.download = 'qrcode.png';
          link.click();
        });

        // Display the QR code container after QR code generation is complete
        qrcodeParentContainer.style.display = 'block';
      }, 100);
    }
  </script>
  <script src="js/qrcode.js"></script>
  <script src="js/qrcode.min.js"></script>

</body>

</html>