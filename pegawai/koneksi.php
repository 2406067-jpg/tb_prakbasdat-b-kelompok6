<?php
$host = "localhost";
$username = "root";
$password = "";
// DI SINI KUNCI PERBAIKANNYA, BRO! Namanya diganti ke db_tugas_kelompok
$database = "db_tugas_kelompok"; 

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("
    <div class='container mt-5'>
        <div class='alert alert-danger' role='alert'>
            Koneksi gagal: " . mysqli_connect_error() . "
        </div>
    </div>");
}
mysqli_set_charset($koneksi, "utf8");

// Cek dulu biar fungsi gak bentrok kalau dipanggil di file lain
if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp" . number_format((float)$angka, 0, ',', '.');
        return $hasil_rupiah;
    } 
}

if (!function_exists('tglIndo')) {
    function tglIndo($tgl)
    {
        if (!$tgl) return '-';
        $bulan = [
            '',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        $d = explode('-', $tgl);
        return $d[2] . ' ' . $bulan[(int)$d[1]] . ' ' . $d[0];
    }
}
?>