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

$get_sql_semua_pelajar = mysqli_query($conn, "SELECT * FROM siswa");
$get_data_semua_pelajar = mysqli_num_rows($get_sql_semua_pelajar);

$get_sql_pelajar_absen_hari_ini = mysqli_query($conn, "SELECT * FROM absen WHERE tanggal='$TanggalHariIni'");
$get_data_pelajar_absen_hari_ini = mysqli_num_rows($get_sql_pelajar_absen_hari_ini);

$get_data_pelajar_tidak_absen_hari_ini = $get_data_semua_pelajar - $get_data_pelajar_absen_hari_ini;

$get_sql_semua_user = mysqli_query($conn, "SELECT * FROM user");
$get_data_semua_user = mysqli_num_rows($get_sql_semua_user);
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
  <title>Ruang<?= $_SESSION['role'] ?> - Absensi Harian</title>
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
      <li class="nav-item">
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
        <div id="collapseTableAbsensiPelajar" class="collapse show" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="card py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pelajar</h6>
            <a class="collapse-item active btn-light" style="border: 0px;" href="absensi_harian.php">
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
            <h1 class="h3 mb-0">Absensi Harian Siswa</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Absensi Harian Siswa</li>
            </ol>
          </div>

          <div class="container bg-body-tertiary py-3 mb-5" id="absensi_harian">
            <form action="#absensi_harian" method="GET">
              <div class="input-group mb-3">
                <input type="date" class="form-control" name="filter_date" value="<?php echo isset($_GET['filter_date']) ? $_GET['filter_date'] : ''; ?>">
                <select class="form-select" name="filter_kelas">
                  <?php
                  $kelasid_wali = $_SESSION['kelasid'];
                  $sql_kelas_wali = mysqli_query($conn, "SELECT * FROM kelas WHERE kelasid='$kelasid_wali'");
                  if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Kepala Sekolah") {
                  ?>
                    <option value="">Semua Kelas</option>
                  <?php
                  }
                  ?>

                  <?php
                  if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Kepala Sekolah") {
                    $sql_kelas = mysqli_query($conn, "SELECT * FROM kelas");
                    while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
                  ?>
                      <option value="<?= $data_kelas['namakelas'] ?>" <?php echo isset($_GET['filter_kelas']) && $_GET['filter_kelas'] == $data_kelas['namakelas'] ? 'selected' : ''; ?>><?= $data_kelas['namakelas'] ?></option>
                    <?php
                    }
                  } else if ($_SESSION['role'] == "Wali Kelas") {
                    if (mysqli_num_rows($sql_kelas_wali) == 0) {
                    ?>
                      <option value="404_Not_Found">Data Error</option>
                      <?php
                    } else {
                      $kelasid = $_SESSION['kelasid'];
                      $sql_kelas = mysqli_query($conn, "SELECT * FROM kelas WHERE kelasid='$kelasid'");
                      while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
                      ?>
                        <option value="<?= $data_kelas['namakelas'] ?>" <?php echo isset($_GET['filter_kelas']) && $_GET['filter_kelas'] == $data_kelas['namakelas'] ? 'selected' : ''; ?>><?= $data_kelas['namakelas'] ?></option>
                  <?php
                      }
                    }
                  }
                  ?>
                </select>
                <button type="submit" class="btn btn-primary">Cari</button>
              </div>
            </form>
            <div class="row">
              <?php
              $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
              $filter_kelas = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';

              $sql = "SELECT siswa.*, jurusan.*, absen.*, kelas.* FROM siswa INNER JOIN absen ON siswa.nis = absen.nis INNER JOIN jurusan ON siswa.jurusanid = jurusan.jurusanid INNER JOIN kelas ON siswa.kelasid = kelas.kelasid WHERE 1";

              if (!empty($filter_date)) {
                $sql .= " AND absen.tanggal = '$filter_date'";
              } elseif ($_SESSION['role'] == "Wali Kelas") {
                $kelasid = $_SESSION['kelasid'];
                if (isset($_GET['filter_kelas'])) {
                  $kelas = $_GET['filter_kelas'];
                  $sql .= " AND kelas.namakelas = '$kelas'";
                } else {
                  $tanggal = date("Y-m-d");
                  $sql .= " AND kelas.kelasid = '$kelasid' AND absen.tanggal = '$tanggal'";
                }
              } elseif (empty($filter_kelas)) {
                $tanggal = date("Y-m-d");
                $sql .= " AND absen.tanggal = '$tanggal'";
              }

              if (!empty($filter_kelas)) {
                $sql .= " AND kelas.namakelas = '$filter_kelas'";
              }

              $sql .= " ORDER BY absen.id DESC";

              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_array($result)) {
                  $tanggal_dari_database = $data["tanggal"];
                  $tanggal_baru = date('d-m-Y', strtotime($tanggal_dari_database));
              ?>

                  <div class="col-xl-6 mb-3">
                    <div class="card space-between-card">
                      <div class="row g-0">
                        <div class="col-md-4">
                          <img src="fotosiswa/<?= $data['fotosiswa'] ?>" class="img-fluid rounded-start" alt="..." style="height: 100%; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title"><?= $data['nama'] ?></h5>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">NIS: <?= $data['nis'] ?></li>
                              <li class="list-group-item">Kelas: <?= $data['namakelas'] ?></li>
                              <li class="list-group-item">Jurusan: <?= $data['kepanjangan'] ?></li>
                              <li class="list-group-item">Jenis Kelamin: <?= $data['jk'] ?></li>
                              <li class="list-group-item">Tanggal: <?= $tanggal_baru ?></li>
                              <li class="list-group-item">
                                <?php
                                if ($data["waktudatang"] == "00:00:00") {
                                ?>
                                  Datang: -
                                <?php
                                } else {
                                ?>
                                  Datang: <?= $data['waktudatang'] ?> WITA
                                  (
                                  <?php
                                  if ($data["keterangandatang"] == "Tepat Waktu") {
                                  ?>
                                    <b class="text-success"><?= $data['keterangandatang'] ?></b>
                                  <?php
                                  } elseif ($data["keterangandatang"] == "Terlambat") {
                                  ?>
                                    <b class="text-danger"><?= $data['keterangandatang'] ?></b>
                                  <?php
                                  } elseif ($data["keterangandatang"] == "Absen Cepat") {
                                  ?>
                                    <b class="text-warning"><?= $data['keterangandatang'] ?></b>
                                  <?php
                                  }
                                  ?>
                                  )
                                <?php
                                }
                                ?>
                              </li>
                              <li class="list-group-item">
                                <?php
                                if ($data["waktupulang"] == "00:00:00") {
                                ?>
                                  Pulang: -
                                <?php
                                } else {
                                ?>
                                  Pulang: <?= $data['waktupulang'] ?> WITA
                                  (
                                  <?php
                                  if ($data["keteranganpulang"] == "Pulang Tepat Waktu") {
                                  ?>
                                    <b class="text-success"><?= $data['keteranganpulang'] ?></b>
                                  <?php
                                  } elseif ($data["keteranganpulang"] == "Pulang Terlambat") {
                                  ?>
                                    <b class="text-danger"><?= $data['keteranganpulang'] ?></b>
                                  <?php
                                  }
                                  ?>
                                  )
                                <?php
                                }
                                ?>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                }
              } else {
                ?>
                <div class="col-12">
                  <div class="alert alert-danger" role="alert">
                    Tidak ada data yang ditemukan.
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>


          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
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

  <script src="js/qrcode.js"></script>
  <script src="js/qrcode.min.js"></script>

</body>

</html>