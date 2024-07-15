<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location:login.php");
} else if (!isset($_SESSION['kodeakses'])) {
    header("Location:../login_akses.php");
} else if (isset($_SESSION['userid']) && $_SESSION['role'] != "Admin" && $_SESSION['role'] != "Kepala Sekolah" && $_SESSION['role'] != "Wali Kelas") {
    header("Location:index.php");
}

// Load TCPDF library
require_once("tcpdf/tcpdf.php");

// Create new PDF document
$pdf = new TCPDF('l', 'mm', 'F4', true, 'UTF-8', true);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setMargins(3, 3, 3);
$pdf->setAutoPageBreak(true, 1);

// Add a page
$pdf->AddPage();

// Set font
$pdf->setFont('helvetica', '', 12);

$tanggal = $_POST['tanggal'];
$kelasid = $_POST['kelasid'];

// $conn = mysqli_connect("localhost", "root", "", "absen");
$sql = "SELECT * FROM kelas WHERE kelasid = '$kelasid'";
$result = mysqli_query($conn, $sql);
$namakelas = '';
while ($row = mysqli_fetch_assoc($result)) {
    $namakelas = $row['namakelas'];
}

$namawali = "-"; // Nilai default

if (isset($_SESSION['kelasid']) != 0) {
    $sql_wali = mysqli_query($conn, "SELECT namalengkap FROM user WHERE kelasid='$kelasid'");
    if ($data_wali = mysqli_fetch_array($sql_wali)) {
        $namawali = $data_wali['namalengkap'];
    }
} else if (isset($_SESSION['kelasid']) == 0) {
    $sql_wali = "SELECT siswa.*, jurusan.*, absen.*, kelas.*
    FROM siswa 
    INNER JOIN absen ON siswa.nis = absen.nis 
    INNER JOIN jurusan ON siswa.jurusanid = jurusan.jurusanid 
    INNER JOIN kelas ON siswa.kelasid = kelas.kelasid
    WHERE siswa.kelasid = '$kelasid'";

    $result_wali = mysqli_query($conn, $sql_wali);
    if ($data_wali = mysqli_fetch_array($result_wali)) {
        $namawali = $data_wali['namalengkap'];
    }
}

function fetch_data()
{
    $output = '';
    $conn = mysqli_connect("localhost", "root", "", "absen");
    date_default_timezone_set('Asia/Makassar');
    $tanggal = $_POST['tanggal'];
    $kelasid = $_POST['kelasid'];

    $sql = "SELECT siswa.*, jurusan.*, absen.*, kelas.*
    FROM siswa 
    INNER JOIN absen ON siswa.nis = absen.nis 
    INNER JOIN jurusan ON siswa.jurusanid = jurusan.jurusanid 
    INNER JOIN kelas ON siswa.kelasid = kelas.kelasid
    WHERE absen.tanggal = '$tanggal' AND siswa.kelasid = '$kelasid'
    ORDER BY siswa.nama ASC";
    $result = mysqli_query($conn, $sql);

    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $tanggal_dari_database = $row['tanggal'];
        $tanggal_baru = date('d-m-Y', strtotime($tanggal_dari_database));

        $waktu_datang = ($row['waktudatang'] != '00:00:00') ? $row['waktudatang'] . ' WITA<br>' . $row['keterangandatang'] : '-';
        $waktu_pulang = ($row['waktupulang'] != '00:00:00') ? $row['waktupulang'] . ' WITA<br>' . $row['keteranganpulang'] : '-';

        $output .= '
        <tr>
            <td align="center">' . $no++ . '.</td>
            <td align="left">' . $row['nama'] . '</td>
            <td align="center">' . $row['nis'] . '</td>
            <td align="center">' . $row['namakelas'] . '</td>
            <td align="left">' . $row['kepanjangan'] . '</td> 
            <td align="center">' . $row['jk'] . '</td> 
            <td align="center">' . $waktu_datang . '</td> 
            <td align="center">' . $waktu_pulang . '</td> 
        </tr>';
    }
    return $output;
}

$content = '
<table border="1" style="padding-top: 5px; padding-bottom: 5px;">
<tr bgcolor="skyblue">
    <th align="center" width="30px"><b>No</b></th>
    <th align="center" width="188px"><b>Nama Peserta</b></th>
    <th align="center" width="60px"><b>NIS</b></th>
    <th align="center" width="80px"><b>Kelas</b></th>
    <th align="center" width="190px"><b>Jurusan</b></th>
    <th align="center" width="90px"><b>Jenis Kelamin</b></th>
    <th align="center" width="135px"><b>Waktu Datang</b></th>
    <th align="center" width="135px"><b>Waktu Pulang</b></th>
</tr>';

$content .= fetch_data(); // Menggunakan output dari fetch_data()
$content .= '
</table>
<div style="width: 100%;"><br><br><br><br><br><br></div>'; // Tambahkan div sebagai pemisah

$header = '
<table width="100%">
    <tr>
        <td width="100px" align="center"><img src="logo/smkn_labuang.jpg" width="65px"></td>
        <td width="710px" align="center">
            <br>
            <b>PEMERINTAH PROVINSI SULAWESI BARAT<br>DINAS PENDIDIKAN DAN KEBUDAYAAN<br>UPTD SMK NEGERI LABUANG<br><font style="font-weight: normal;">Jl. Poros Majene, Laliko, Campalagian, Kabupaten Polewali Mandar, Sulawesi Barat 91353, Indonesia</font></b>
        </td>
        <td width="100px" align="center"><img src="logo/logo-provinsi-sulawesi-barat.jpg" width="65px"></td>
    </tr>
</table>
<hr style="height: 2px;">
<table>
    <tr>
        <td>Daftar Absensi Harian Siswa/Kelas : ' . $namakelas . '</td>
        <td>Wali Kelas: ' . $namawali . '</td>
        <td align="right">Tanggal : ' . date('d-m-Y', strtotime($tanggal)) . '</td>
    </tr>
</table>
<hr style="height: 3px; color: white;">';

// Output the HTML content with header
$pdf->writeHTML($header . $content, true, true, true, true, '');

// Define a function to set the footer
function setFooter($pdf, $tanggal)
{
    // Array hari dalam Bahasa Indonesia
    $hari = array(
        1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis',
        5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'
    );

    // Array bulan dalam Bahasa Indonesia
    $bulan = array(
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    );

    $timestamp = strtotime($tanggal);
    $day = date('j', $timestamp);
    $month_number = (int)date('n', $timestamp);
    $year = date('Y', $timestamp);

    // Mendapatkan hari berdasarkan tanggal
    $day_of_week = date('N', $timestamp);

    $footer = '
    <table width="100%">
        <tr>
            <td width="83%"></td>
            <td width="17%" align="left">Labuang, ' . $hari[$day_of_week] . ', ' . $day . ' ' . $bulan[$month_number] . ' ' . $year . '<br>Kepala UPTD SMKN Labuang<br><img src="default/ttd_kepala_sekolah_bapak_darwis.jpg" width="150px">
                <div style="border-bottom: 1px solid black;">Darwis, S.S., M.Pd</div>NIP. 19720702 200501 1 010
            </td>
        </tr>
    </table>';
    $pdf->SetY(-48); // Adjust the position to create more space from the table
    $pdf->SetFont('helvetica', '', 10); // Set font for the footer
    $pdf->writeHTML($footer, true, false, true, false, 'R'); // Add the text on the right side
}

// Set footer dengan teks "Labuang, tanggal hari ini" dalam Bahasa Indonesia berdasarkan $tanggal dari database
setFooter($pdf, $tanggal);

// Close and output PDF document
$pdf->Output('Data Absensi Siswa Kelas ' . $namakelas . ' ' . date('d-m-Y', strtotime($tanggal)) . ' UPTD SMK Negeri Labuang.pdf', 'I');
